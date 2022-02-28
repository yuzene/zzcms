<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Model\Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    //返回作者列表视图
    public function index(Request $request){
        $num = $request->input('num') ? $request->input('num') : 3;
        $authname = $request->input('authname') ? $request->input('authname') : '';
        $auths = Auth::orderBy('id', 'asc')->where('authname', 'like', '%' . $authname . '%')->where('authdel', 1)->paginate($num)->appends(['num' => $num]);
        foreach ($auths as $auth){
            $auth->authintro = mb_substr($auth->authintro,0, 25,'utf-8');
        }
        $count = Auth::where('authdel', '>', 0)->count();
        return View('admin.auth.index', compact('auths', 'num', 'count', 'authname'));
    }

    //处理作者编辑请求并返回试图
    public function edit($id){
        $auth = Auth::find($id);
        return view('admin.auth.edit', compact('auth'));
    }
    //处理作者编辑
    public function deal(Request $request){
        $input = $request->all();
        $authNameExit = Auth::where('id', '!=', $input['id'])->where('authname', $input['authname'])->first();
        $authKeyExit = Auth::where('id', '!=', $input['id'])->where('authkey', $input['authkey'])->first();
        if($authNameExit){
            $res = [
                'code' => 201,
                'message' => '作者名已经存在，请重新输入'
            ];
        }elseif ($authKeyExit){
            $res = [
                'code' => 201,
                'message' => '作者KEY已经存在，请重新输入'
            ];
        }else{
            $auth = Auth::find($input['id']);
            $auth->authname = $input['authname'];
            $auth->authkey = $input['authkey'];
            $auth->authintro = $input['authintro'];
            $result = $auth->save();
            if ($result) {
                $res = [
                    'code' => 200,
                    'message' => '修改成功'
                ];
            } else {
                $res = [
                    'code' => 500,
                    'message' => '修改失败'
                ];

            }
        }
        return $res;
    }
    //作者删除，只有文章为空的作者才可以删除，否者不予以删除
    public function delete($id){
        $auth = Auth::find($id);
        $auth->authdel = 0;
        $result = $auth->save();
        if ($result) {
            $data = [
                'status' => 1,
                'message' => '删除成功'
            ];
        } else {
            $data = [
                'status' => 0,
                'message' => '删除失败'
            ];

        }
        return $data;



    }
    //删除多个作者
    public function delAll(Request $request){
        $input = $request->all();
        $ids = $input['ids'];
        foreach ($ids as $v){
            $sort = Auth::find($v);
            $sort->authdel = 0;
            $sort->save();
        }
        return  $data = [
            'status' => 1,
            'message' => '删除成功'
        ];

    }
    //添加作者返回视图
    public function add(){
        return view('admin.auth.add');
    }
    //添加作者
    public function create(Request $request){
        $input = $request->all();
        $authname = Auth::where('authname', $input['authname'])->exists();
        $authkey = Auth::where('authkey', $input['authkey'])->exists();
        if($authname){
            $res = [
                'code' => 201,
                'message' => '作者名已存在'
            ];
        }elseif ($authkey){
            $res = [
                'code' => 201,
                'message' => '作者KEY已存在'
            ];
        }else{
            $result = Auth::create(['authname'=>$input['authname'], 'authkey'=>$input['authkey'], 'authintro'=>$input['authintro']]);
            if ($result) {
                $res = [
                    'code' => 200,
                    'message' => '添加成功'
                ];
            } else {
                $res = [
                    'code' => 500,
                    'message' => '添加失败'
                ];

            }
        }

        return $res;


    }

}
