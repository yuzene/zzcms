<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Model\Rule;
use App\Models\Model\User;
use App\Models\Model\Site;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    //返回规则视图
    public function index(){
        $rules = Rule::where('ruledel', 1)->get();
        $count = Rule::where('ruledel', 1)->count();
        return view('admin.rule.index', compact('rules', 'count'));
    }
    //返回添加规则视图
    public function add(){
        $sites  = Site::where('sitedel', 1)->get();
        return view('admin.rule.add', compact('sites'));
    }
    //处理添加规则
    public function deal(Request $request){
        $input = $request->all();
        $ruleauth = User::find($input['ruleauth']);
        $rule = new Rule();
        $rule->ruleauth = $ruleauth->username;
        $rule->rulename = $input['rulename'];
        $rule->sid = $input['sid'];
        $rule->list = $input['list'];
        $rule->list_article_id = $input['list_article_id'];
        $rule->list_article_name = $input['list_article_id'];
        $rule->info = $input['info'];
        $rule->info_article_title = $input['info_article_title'];
        $rule->info_article_auth = $input['info_article_auth'];
        $rule->info_article_sort = $input['info_article_sort'];
        $rule->info_article_content = $input['info_article_content'];
        $result = $rule->save();
        if($result){
            $res = [
                'code' => 200,
                'message' => '添加成功'
            ];
        }else{
            $res = [
                'code' => 500,
                'message' => '添加失败，请联系管理员'
            ];
        }
        return $res;

    }
    //规则编辑，返回视图
    public function edit($id){
        $rule = Rule::find($id);
        $sites  = Site::where('sitedel', 1)->get();
        return view('admin.rule.edit', compact('rule','sites'));
    }
    //处理规则编辑
    public function editDeal(Request $request){
        $input = $request->all();
        $rule = Rule::find($input['id']);
        $ruleauth = User::find($input['ruleauth']);
        $rule->ruleauth = $ruleauth->username;
        $rule->rulename = $input['rulename'];
        $rule->sid = $input['sid'];
        $rule->list = $input['list'];
        $rule->list_article_id = $input['list_article_id'];
        $rule->list_article_name = $input['list_article_id'];
        $rule->info = $input['info'];
        $rule->info_article_title = $input['info_article_title'];
        $rule->info_article_auth = $input['info_article_auth'];
        $rule->info_article_sort = $input['info_article_sort'];
        $rule->info_article_content = $input['info_article_content'];
        $result = $rule->save();
        if($result){
            $res = [
                'code' => 200,
                'message' => '修改成功'
            ];
        }else{
            $res = [
                'code' => 500,
                'message' => '修改失败，请联系管理员'
            ];
        }
        return $res;
    }
    //规则删除
    public function delete($id){
        $rule = Rule::find($id);
        $rule->ruledel = 0;
        $result = $rule->save();
        if($result){
            $data = [
                'status' => 1,
                'message' => '删除成功'

            ];
        }else{
            $data = [
                'status' => 0,
                'message' => '删除失败，请联系管理员'

            ];
        }
        return $data;

    }
    //规则批量删除
    public function all(Request $request){
        $ids = $request->input('ids');
        foreach ($ids as $id){
            $rule = Rule::find($id);
            $rule->ruledel = 0;
            $rule->save();
        }
        return  $data = [
            'status' => 1,
            'message' => '删除成功'
        ];
    }
    //规则测试
    public function test($id){
        $ids = [];
        $rule = Rule::find($id);
        if(strpos($rule->list, '[page]')){
            $rule->list = str_replace('[page]', 1, $rule->list);
        }
        if(file_get_contents($rule->list)){
            echo '<span style="color:darkblue;">采集列表页地址:'.$rule->list. '<br/></span>';
        }else{
            echo '<span style="color:darkblue;">采集列表页地址:<span style="color: red;">'.$rule->list. '失败</span><br/></span>';
        }
        $listContent = file_get_contents($rule->list);
        preg_match_all($rule->list_article_id, $listContent, $ids);
        if($ids){
            echo '<span style="color:green;">获取文章列表成功，数目:'.count($ids[1]).'</span><br/>';
        }
        for($i=0; $i<5; $i++){
            echo '文章地址：'.str_replace('[ID]', $ids[1][$i], $rule->info).'<br/>';
        }
        echo '<span style="color:darkblue;">列表后面内容省略............</span><br/>';
        $url = str_replace('[ID]', $ids[1][0], $rule->info);
        echo '<br/>采集信息页地址:'.$url.'<br/>';
        $articleContent = file_get_contents($url);
        if($articleContent){
            echo '<span style="color:green;">获取文章信息成功</span><br/>';
        }
        //处理字符集，全部转化为utf8
        preg_match('#<meta.*charset=([a-z\d]*)#i', $articleContent, $charset);
        $articleContent = iconv($charset[1], 'utf-8', $articleContent);
        preg_match($rule->info_article_title, $articleContent, $article_name);
        if($article_name[1]){
            echo '-文章标题：'.$article_name[1].'<br/>';
        }else{
            echo '-文章标题：<span style="color: red">文章标题获取失败</span><br/>';
        }
        preg_match($rule->info_article_auth, $articleContent, $info_article_auth);
        if($info_article_auth[1]){
            echo '-文章作者：'.$info_article_auth[1].'<br/>';
        }else{
            echo '-文章作者：<span style="color: red">文章作者获取失败</span><br/>';
        }
        preg_match($rule->info_article_sort, $articleContent, $info_article_sort);
        if($info_article_sort[1]){
            echo '-文章分类：'.$info_article_sort[1].'<br/>';
        }else{
            echo '-文章分类：<span style="color: red">文章分类获取失败</span><br/>';
        }
        preg_match($rule->info_article_content, $articleContent, $info_article_content);
        //处理文章内的图片
            $imgs = [];
            $pregRule = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/";
            if(preg_match($pregRule, $info_article_content[1])){
                preg_match_all($pregRule, $info_article_content[1], $imgs);
            //不带域名图片处理
                // 从 URL 中获取访问的主机名
                preg_match("/^(http\w?:\/\/)?([^\/]+)/i", $rule->list, $matches);
                $host = $matches[0];
                // 从主机名中获得域名
                preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
                //判断文章图片是否带域名
                foreach ($imgs[1] as $img){
                    if(!preg_match('#'.$matches[0].'#', $img)){
                        $imgNew = $host.$img;
                        //不带域名的图片地址，替换成新地址
                        $info_article_content[1] = str_replace($img, $imgNew, $info_article_content[1]);
                    }
                }
        }
        if($info_article_content[1]){
            echo '-文章内容：<br/>'.$info_article_content[1];
        }else{
            echo '-文章内容：<span style="color: red">文章内容获取失败</span><br/>';
        }
    }
}
