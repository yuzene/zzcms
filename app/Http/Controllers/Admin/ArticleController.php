<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Model\Article;
use App\Models\Model\Auth;
use App\Models\Model\Sort;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    //返回文章列表视图
    public function index(Request $request){
        $request->input('num') ? $num = $request->input('num') : $num = 10;
        $request->input('article_name') ? $article_name = $request->input('article_name') : $article_name = '';
        $request->input('article_auth') ? $article_auth = $request->input('article_auth') : $article_auth = '';
        if($article_auth){
            $auth = Auth::where('authname', $article_auth)->first();
            $auth ? $authId = $auth->id : $authId = 0;
        }
       if($article_auth){
           $articles = Article::orderBy('id', 'asc')->
           where('article_name', 'like', '%' . $article_name . '%')->where('article_auth', $authId)->
           where('articledel', 1)->paginate($num);
       }else{
           $articles = Article::orderBy('id', 'asc')->
           where('article_name', 'like', '%' . $article_name . '%')->
           where('articledel', 1)->paginate($num);
       }
        foreach ($articles as $article){
            $article->content = mb_substr($article->content,0, 25,'utf-8');
        }
        $count = Article::where('articledel', '>', 0)->count();
        return View('admin.article.index', compact('articles','article_name', 'num', 'article_auth', 'count'));

    }

    //文章编辑
    public function edit($id){
        $article = Article::find($id);
        $sort = new Sort();
        $sorts = $sort->list();
        return view('admin.article.edit', compact('article', 'sorts'));
    }
    //文章编辑处理
    public function deal(Request $request){
        $input = $request->all();
        $authId = Auth::where('authname', $input['article_auth'])->first();
        if(!$authId){
            $res = [
                'code' => 500,
                'message' => '作者不存在，请先添加作者'
            ];
            return $res;
        }
        $articleInfo = [
            'article_name' => $input['article_name'],
            'article_auth' => $authId->id,
            'article_sort' => $input['article_sort'],
            'content' => $input['content'],
            'allvisit' => $input['allvisit'],
            'monthvisit' => $input['monthvisit'],
            'weekvisit' => $input['weekvisit'],
            'dayvisit' => $input['dayvisit'],

        ];
        $result = Article::where('id', $input['id'])->update($articleInfo);
        if ($result) {
            $res = [
                'code' => 200,
                'message' => '修改成功'
            ];
        } else {
            $res = [
                'code' => 500,
                'message' => '修改失败，请联系管理员'
            ];

        }
        return $res;
    }
    //文章删除
    public function delete($id){
        $article = Article::find($id);
        $article->articledel = 0;
        $result = $article->save();
        if ($result) {
            $data = [
                'status' => 1,
                'message' => '删除成功'
            ];
        } else {
            $data = [
                'status' => 0,
                'message' => '删除失败，请联系管理员'
            ];

        }
        return $data;
    }
    //文章批量删除
    public function delAll(Request $request){
        $input = $request->all();
        $ids = $input['ids'];
        foreach ($ids as $v){
            $article = Article::find($v);
            $article->articledel = 0;
            $article->save();
        }
        return  $data = [
            'status' => 1,
            'message' => '删除成功'
        ];
    }

    //返回添加文章视图
    public function add(){
        $sort = new Sort();
        $sorts = $sort->list();
        return view('admin.article.add', compact( 'sorts'));
    }
    //文章添加处理
    public function addDeal(Request $request){
        $input = $request->all();
        $authId = Auth::where('authname', $input['article_auth'])->first();
        if(!$authId){
            $res = [
                'code' => 500,
                'message' => '作者不存在，请先添加作者'
            ];
            return $res;
        }
        $article = new Article();
        $article->article_name = $input['article_name'];
        $article->article_auth = $authId->id;
        $article->article_sort = $input['article_sort'];
        $article->content = $input['content'];
        $article->sourceid = 1;
        $result = $article->save();
        if ($result) {
            $res = [
                'code' => 200,
                'message' => '添加成功'
            ];
        } else {
            $res = [
                'code' => 500,
                'message' => '添加失败，请联系管理员'
            ];

        }
        return $res;
    }
}
