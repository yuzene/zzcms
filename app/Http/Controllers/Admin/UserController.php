<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //请求用户数据
    public function index($val, $num = 3)
    {
    //appends 方法向分页链接中添加查询参数
        return User::orderBy('id', 'asc')->where('username', 'like', '%' . $val . '%')->where('userdel', 1)->paginate($num)->appends(['num' => $num]);
    }

    //用户列表分页
    public function page(Request $request)
    {
        $num = $request->input('num', 3);
        $val = $request->input('val', '');
        $user = new UserController();
        $users = $user->index($val, $num);
        $count = User::where('userdel', '>', 0)->count();
        return view('admin.user.index', compact('users', 'num', 'count', 'val'));
    }

    //返回用户添加页面
    public function add()
    {
        return view('admin.user.add');
    }


    //处理添加用户
    public function create(Request $request)
    {
        $input = $request->all();
        $ip = $request->getClientIp();
        $validated = $request->validate([
            'username' => 'required|max:255',
            'password' => 'required',
            'email' => 'required|email',
        ]);
        $user = User::where('username', $input['username'])->value('id');
        if($user){
            $res = [
                'code' => 201,
                'message' => '用户名已存在'
            ];
        }else{
            $password = md5('zz' . $input['password']);
            $result = User::create(['username' => $input['username'], 'password' => $password, 'email' => $input['email'], 'registerip' => $ip, 'loginip' => $ip]);
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

    //处理用户状态
    public function status($id)
    {
        $user = User::find($id);
        if ($user->status == 1) {
            $user->status = 0;
        } else {
            $user->status = 1;
        }
        $user->save();
        return back();
    }

    //返回用户编辑视图
    public function edit($id){
        $user = User::find($id);
        return view('admin.user.edit', compact('user'));
    }
    //用户信息修改处理
    public function alter(Request $request){
        $input = $request->all();
        $user = User::find($input['id']);
        if(!array_key_exists('status',$input)){
            $user->email = $input['email'];
            $user->status = 0;
        }else{
            $user->email = $input['email'];
            $user->status = 1;
        }
        $result =  $user->save();
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
        return $res;
    }
    //返回用户密码视图
    public function pass($id){
        $user = User::find($id);
        return view('admin.user.pass', compact('user'));
    }
    //修改密码处理
    public function deal(Request $request){
        $input = $request->all();
        $user = User::find($input['id']);
        $user->password = md5('zz'.$input['password']);
        $result = $user->save();
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
        return $res;
    }
    //用户删除
    public function delete($id){
        $user = User::find($id);
        $user->userdel = 0;
        $result = $user->save();
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
    //多个用户删除
    public function delAll(Request $request){
        $input = $request->all();
        $ids = $input['ids'];
        foreach ($ids as $v){
            $user = User::find($v);
            $user->userdel = 0;
            $user->save();
        }
        return  $data = [
                'status' => 1,
                'message' => '删除成功'
            ];
    }
}
