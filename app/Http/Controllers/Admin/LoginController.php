<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use MongoDB\Driver\Session;

class LoginController extends Controller
{
    //用户登录
    public function login()
    {
        //如果session存在，直接进入首页
        if(session()->get('role') == '管理员'){
            return redirect('admin/index/index');
        }
        //session不存在返回登陆页面
        return view('admin.user.login');
    }

    //处理用户登录
    public function doLogin(Request $request)
    {
        //接收数据
        $input = $request->except('_token');
        $ip = $request->getClientIp();
        //数据验证
        $rules = [
            'username' => 'required|max:255',
            'password' => 'required',
        ];
        $messages = [
            'username.required' => '用户名必须输入',
            'password.required' => '密码必须输入'
        ];
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return redirect('login')->withErrors($validator)->withInput();
        }
        //验证用户
        $username = $input['username'];
        $password = md5('zz'.$input['password']);
        $captcha = strtolower($input['captcha']);
        $user = User::where('username', $username)->first();
        if(!$user){
            return redirect('login')->with('error', '用户名不存在,请先注册');
        }
        if($password != $user->password){
            return redirect('login')->with('error', '密码不正确');
        }
        if (strtolower(session('milkcaptcha')) != $captcha) {
            return redirect('login')->with('error', '验证码不正确');
        }
        if($user->status == 0){
            return redirect('login')->with('error', '账号被禁用，请联系管理员');
        }
        //改变用户最后一次登录ip地址和登录时间
        $user->updated_at = date('Y-m-d H:i:s');
        $user->loginip = $ip;
        $user->save();
        //保存用户信息到session
        session()->put(['user_id' => $user->id]);
        //跳转到后台首页
        return redirect('admin/index/index')->with('username', $user->username);
    }
    //处理用户退出登录
    public function logout(){
        session()->flush();
        return redirect('login');
    }
}
