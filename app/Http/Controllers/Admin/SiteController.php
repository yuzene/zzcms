<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Model\Article;
use App\Models\Model\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    //采集站点列表
    public function index(){
        $sites = Site::where('sitedel', '>', 0)->get();
        $count = Site::where('sitedel', '>', 0)->count();
        return view('admin.site.index', compact('sites', 'count'));
    }
    //采集站点状态切换
    public function status($id){
        $site = Site::find($id);
        if(!$site->sitedisable){
            $site->sitedisable = 1;
        }else{
            $site->sitedisable = 0;
        }
        $site->save();
        return back();
    }
    //添加采集站点，返回视图
    public function add(){
        return view('admin.site.add');
    }
    //处理添加站点
    public function deal(Request  $request){
        $input = $request->all();
        $siteabb = Site::where('siteabb' ,$input['siteabb'])->exists();
        if($siteabb){
            $res = [
                'code' => 201,
                'message' => '站点缩写已存在'
            ];
        }else{
            $result = Site::create(['sitename'=>$input['sitename'], 'siteabb' => $input['siteabb'], 'cid' => $input['cid']]);
            if($result){
                $res = [
                    'code' => 200,
                    'message' => '添加成功'
                ];
            }else {
                $res = [
                    'code' => 500,
                    'message' => '添加失败'
                ];

            }
        }
        return  $res;
    }
    //返回站点编辑视图
    public function edit($id){
        $site = Site::find($id);
        return view('admin.site.edit', compact('site'));
    }
    //处理站点编辑
    public function editDeal(Request $request){
        $siteExists = Site::where('id', '!=', $request->input('id'))->where('siteabb', $request->input('siteabb'))->exists();
        if($siteExists){
            $res = [
                'code' => 201,
                'message' => '站点缩写已存在'
            ];
        }else{
            $site = Site::find($request->input('id'));
            $site->sitename = $request->input('sitename');
            $site->siteabb = $request->input('siteabb');
            $site->cid = $request->input('cid');
            $result = $site->save();
            if($result){
                $res = [
                    'code' => 200,
                    'message' => '修改成功'
                ];
            }else {
                $res = [
                    'code' => 500,
                    'message' => '修改失败,请联系管理员'
                ];

            }
        }

        return $res;

    }
    //处理站点删除
    public function delete($id){
        $article = Article::where('sourceid', $id)->exists();
        if($article){
            $data = [
                'status' => 0,
                'message' => '站点不为空，请先清空站点'

            ];
        }else{
            $site = Site::find($id);
            $site->sitedel = 0;
            $result = $site->save();
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
        }

        return $data;
    }
//    //批量删除站点
//    public function all(Request $request){
//        $ids = $request->input('ids');
//        foreach ($ids as $id){
//            $site = Site::find($id);
//            $site->sitedel = 0;
//            $site->save();
//        }
//        return  $data = [
//            'status' => 1,
//            'message' => '删除成功'
//        ];
//    }
}
