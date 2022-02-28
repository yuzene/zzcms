<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //返回首台首页
    public function index(){
        return view('admin.index.index');
    }
    //返回后台欢迎首页
    public function welcome(){
        return view('public.welcome');
    }
}
