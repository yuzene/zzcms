<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Model\Auth;
use App\Models\Model\Rule;
use App\Models\Model\Article;
use App\Models\Model\Sort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\Inline\Element\Strong;
use Overtrue\Pinyin\Pinyin;

class CollectController extends Controller
{
    public function list($id)
    {
        $rule = Rule::find($id);
        return view('admin.collect.list', compact('rule'));
    }

    //列表采集
    public function listCollect(Request $request)
    {
        $input = $request->all();
        $rule = Rule::find($input['id']);
        echo '开始采集：' . $rule->rulename . '<br/>';
        $page = strpos($rule->list, '[page]');
        if ($page) {
            if (empty($input['pagemin']) || empty($input['pagemax'])) {
                echo '<span style="color:red;">采集失败，请检查起止页码</span>';
            } elseif (!(is_numeric($input['pagemin']) && is_numeric($input['pagemax']))) {
                echo '<span style="color:red;">采集失败，请检查起止页码</span>';
            } else {
                $pagemin = $input['pagemin'];
                $pagemax = $input['pagemax'];
            }
        }
        //循环多个列表，获取列表地址，去调用获取文章地址的方法
        //定义一个获取文章地址的数组
        $urls = [];
        if ($page) {
            for ($i = $pagemin; $i <= $pagemax; $i++) {
                $list = str_replace('[page]', $i, $rule->list);
                $listContent = file_get_contents($list);
                preg_match_all($rule->list_article_id, $listContent, $ids);
                foreach ($ids[1] as $v) {
                    $info = str_replace('[ID]', $v, $rule->info);
                    array_push($urls, $info);
                }
            }
        }
        //文章采集入库
        $this->warehousing($urls,$rule);
    }
    //采集文章入库
    public function warehousing($urls, $rule){
        //文章采集入库
        foreach ($urls as $value) {
            $article = $this->infoCollect($value, $rule);
            if($article == '没有内容'){
                echo '<br/>地址<span style="color: red;">  '.$value.'  </span>的文章不存在，跳过！<br/>';
            }else{
                if ($article->article_name) {
                    echo '<br/>正在采集《' . $article->article_name . '》<br/>';
                } else {
                    echo '<span style="color: red;">获取书名失败，禁止入库</span><br/>';
                    continue;
                }
                if (!$article->article_auth) {
                    echo '<span style="color: red;">获取作者失败，禁止入库</span><br/>';
                    continue;
                } else {
                    $articleId = $this->auth($article->article_auth);
                    $article->article_auth = $articleId;
                }
                if (!$article->article_sort) {
                    echo '<span style="color: red;">获取分类失败，禁止入库</span><br/>';
                    continue;
                } else {
                    $article->article_sort = $this->sort($article->article_sort);
                }
                if (!$article->content) {
                    echo '<span style="color: red;">获取文章内容失败，禁止入库</span><br/>';
                    continue;
                } else {
                    $article->content = $this->imgs($article->content, $rule);
                }
                //文章源站
                $article->sourceid = $rule->sid;
                //查重
                $articles = Article::where('article_name', $article->article_name)->first();
                if ($articles && $articles->article_auth == $articleId) {
                    echo '<span style="color: red;">文章《' . $article->article_name . '》在本站已存在跳过</span><br/>';
                    continue;
                }

                $result = $article->save();
                if ($result) {
                    echo '<span style="color: green;">《' . $article->article_name . '》入库成功！</span><br/>';
                }
            }
        }
        echo '<br/><span style="color: green">任务已采集完成</span>';
    }
    //返回文章起止ID采集视图
    public function number(){
        $rules = Rule::where('ruledel', 1)->get();
        return view('admin.collect.number', compact('rules'));
    }
    //返回文章列表ID采集视图
    public function listnum(){
        $rules = Rule::where('ruledel', 1)->get();
        return view('admin.collect.listnum', compact('rules'));
    }
    //处理文章号采集
    public function numdeal(Request $request){
        $input = $request->all();
        $rule = Rule::find($input['rid']);
        $urls = [];
        if($input['way'] == 'startend'){
            if(!is_numeric($input['startId']) || !is_numeric($input['endId']) || $input['endId'] < $input['startId']){
                echo '<span style="color: red">输入的起止书号不正确，请重新输入</span>';
            }else{
                $startId = $input['startId'];
                $endId = $input['endId'];
                for ($i = $startId; $i<=$endId; $i++){
                    $info = str_replace('[ID]', $i, $rule->info);
                    array_push($urls, $info);
                }
                //文章采集入库
                $this->warehousing($urls,$rule);
            }
        }elseif(($input['way'] == 'list')){
            $ids =  explode(',', $input['articleIds']);
            foreach ($ids as $v){
                $info = str_replace('[ID]', $v, $rule->info);
                array_push($urls, $info);
            }
            //文章采集入库
            $this->warehousing($urls,$rule);
        }
    }

    //根据文章地址采集内容
    public function infoCollect($url, $rule)
    {
        $article = new Article();
        $content = @file_get_contents($url);
        if(!$content){
            $article = '没有内容';
        }else{
            $contents = ToolController::charset($content);
            preg_match($rule->info_article_title, $contents, $article_name);
            $article->article_name = $article_name[1];
            preg_match($rule->info_article_auth, $contents, $article_auth);
            $article->article_auth = $article_auth[1];
            preg_match($rule->info_article_sort, $contents, $article_sort);
            $article->article_sort = $article_sort[1];
            preg_match($rule->info_article_content, $contents, $content);
            $article->content = $content[1];
        }
        return $article;


    }

    //采集内容处理作者
    public function auth($auth)
    {
        $isAuth = Auth::where('authname', $auth)->first();
        if ($isAuth) {
            $authId = $isAuth->id;
        } else {
            $pinyin = new Pinyin();
            $authkey = $pinyin->permalink($auth, '_');
            $result = Auth::create(['authname' => $auth, 'authkey' => $authkey]);
            $authId = $result->id;
        }
        return $authId;
    }

    //处理作者分类
    public function sort($sortname)
    {
        $path = Storage::path('match.php');
        static $match;
        if(empty($match)){
            $match = include_once $path;
        }
        foreach ($match as $k => $v){
            foreach ($v as $n){
                if($n == $sortname){
                    $sortname = $k;
                }
            }
        }
        $sort = Sort::where('sortname', $sortname)->first();
        $sortId = $sort->id;
        return $sortId;
    }

    //处理文章内的图片
    public function imgs($content, $rule)
    {
        $imgs = [];
        $pregRule = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/";
        if (preg_match($pregRule, $content)) {
            preg_match_all($pregRule, $content, $imgs);
            //不带域名图片处理
            // 从 URL 中获取访问的主机名
            preg_match("/^(http\w?:\/\/)?([^\/]+)/i", $rule->list, $matches);
            $host = $matches[0];
            // 从主机名中获得域名
            preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
            //判断文章图片是否带域名
            foreach ($imgs[1] as $img) {
                if (!preg_match('#' . $matches[0] . '#', $img)) {
                    $imgNew = $host . $img;
                    //不带域名的图片地址，替换成新地址
                    $content = str_replace($img, $imgNew, $content);
                }
            }
        }
        return $content;
    }

    //返回分类替换视图
    public function match()
    {
        $sorts = Sort::where('sortdel', 1)->get();
        $match = Storage::get('match.php');
        if($match){
            $match = substr($match, 13, -1);
            return view('admin.collect.match', compact('sorts', 'match'));
        }else{
            return view('admin.collect.match', compact('sorts'));
        }

    }

    //处理保存分类匹配
    public function matchDeal(Request $request)
    {
        $match = $request->input('match');
        $result  = Storage::put('match.php', '<?php return '.$match.';');
        if($result){
            $res = [
                'code' => 200,
                'data' => '保存成功',
            ];
        }
        return $res;
    }


}
