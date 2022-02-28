<?php

use App\Http\Middleware\RoleAdmin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//用户登录返回视图
Route::match(['get','post'],'login', [\App\Http\Controllers\Admin\LoginController::class, 'login']);
//验证码路由
Route::get('/captcha', [\App\Http\Controllers\Admin\CodeController::class, 'captcha']);
//处理后台登陆
Route::match(['post','get'],'admin/login', [\App\Http\Controllers\Admin\LoginController::class, 'doLogin']);
Route::middleware([RoleAdmin::class])->group(function(){
    //后台首页
    Route::match(['post','get'],'admin/index/index', [\App\Http\Controllers\Admin\IndexController::class, 'index']);
    //后台欢迎页
    Route::match(['get','post'], 'public/welcome', [\App\Http\Controllers\Admin\IndexController::class, 'welcome']);
    //后台管理员退出登录
    Route::match(['get','post'],'admin/logout',[\App\Http\Controllers\Admin\LoginController::class, 'logout']);
    //用户列表
    //Route::match(['get','post'],'/user/index',[\App\Http\Controllers\Admin\UserController::class, 'index']);
    //用户列表分页
     Route::match(['get','post'],'/user/list/page',[\App\Http\Controllers\Admin\UserController::class, 'page']);
    //添加用户页面
    Route::match(['get','post'],'/user/add',[\App\Http\Controllers\Admin\UserController::class, 'add']);
    //添加用户处理
    Route::match(['get','post'],'/user/create',[\App\Http\Controllers\Admin\UserController::class, 'create']);
    //处理用户状态
    Route::match(['get','post'],'/user/status/{id}',[\App\Http\Controllers\Admin\UserController::class, 'status'])->where('id', '[0-9]+');
    //返回用户编辑
    Route::match(['get','post'],'/user/edit/{id}',[\App\Http\Controllers\Admin\UserController::class, 'edit'])->where('id', '[0-9]+');
    //用户信息修改处理
    Route::match(['get','post'],'/user/alter',[\App\Http\Controllers\Admin\UserController::class, 'alter']);
    //修改密码视图
    Route::match(['get','post'],'/user/pass/{id}',[\App\Http\Controllers\Admin\UserController::class, 'pass'])->where('id', '[0-9]+');
    //修改密码处理
    Route::match(['get','post'],'/user/pass/deal',[\App\Http\Controllers\Admin\UserController::class, 'deal']);
    //用户删除
    Route::match(['get','post'],'/user/delete/{id}',[\App\Http\Controllers\Admin\UserController::class, 'delete'])->where('id', '[0-9]+');
    //多个用户删除
    Route::match(['get','post'],'/user/delAll',[\App\Http\Controllers\Admin\UserController::class, 'delAll']);

    //分类列表视图
    Route::match(['get','post'],'/sort/list',[\App\Http\Controllers\Admin\SortController::class, 'index']);
    //返回添加分类视图
    Route::match(['get','post'],'/admin/sort/create',[\App\Http\Controllers\Admin\SortController::class, 'create']);
    //处理添加分类
    Route::match(['get','post'],'/admin/create/deal',[\App\Http\Controllers\Admin\SortController::class, 'deal']);
    //返回修改分类视图
    Route::match(['get','post'],'/admin/sort/edit/{id}',[\App\Http\Controllers\Admin\SortController::class, 'edit'])->where('id', '[0-9]+');
    //处理分类修改
    Route::match(['get','post'],'/admin/edit/deal',[\App\Http\Controllers\Admin\SortController::class, 'editDeal']);
    //删除分类
    Route::match(['get','post'],'/admin/sort/delete/{id}',[\App\Http\Controllers\Admin\SortController::class, 'delete'])->where('id', '[0-9]+');
    //批量删除分类
    Route::match(['get','post'],'/admin/user/delAll',[\App\Http\Controllers\Admin\SortController::class, 'delAll']);

    //返回作者列表视图
    Route::match(['get','post'],'/admin/auth/index',[\App\Http\Controllers\Admin\AuthController::class, 'index']);
    //返回作者编辑视图
    Route::match(['get','post'],'/auth/edit/{id}',[\App\Http\Controllers\Admin\AuthController::class, 'edit']);
    //处理作者编辑
    Route::match(['get','post'],'/auth/edit/deal',[\App\Http\Controllers\Admin\AuthController::class, 'deal']);
    //删除作者
    Route::match(['get','post'],'/auth/delete/{id}', [\App\Http\Controllers\Admin\AuthController::class, 'delete']);
    //批量删除作者
    Route::match(['get','post'],'/auth/delAll',[\App\Http\Controllers\Admin\AuthController::class, 'delAll']);
    //添加作者返回视图
    Route::match(['get','post'],'/admin/auth/create',[\App\Http\Controllers\Admin\AuthController::class, 'add']);
    //添加作者处理
    Route::match(['get','post'],'/auth/create', [\App\Http\Controllers\Admin\AuthController::class, 'create']);

    //返回文章列表视图
    Route::match(['get', 'post'], '/admin/article/index', [\App\Http\Controllers\Admin\ArticleController::class, 'index']);
    //文章编辑
    Route::match(['get','post'], '/article/edit/{id}', [\App\Http\Controllers\Admin\ArticleController::class, 'edit']);
    //编辑文章处理
    Route::match(['get','post'], '/article/edit/deal', [\App\Http\Controllers\Admin\ArticleController::class ,'deal']);
    //文章删除
    Route::match(['get', 'post'], '/article/delete/{id}', [\App\Http\Controllers\Admin\ArticleController::class, 'delete']);
    //文章批量删除
    Route::match(['get', 'post'], '/article/delete/all', [\App\Http\Controllers\Admin\ArticleController::class, 'delAll']);
    //返回添加文章视图
    Route::match(['get', 'post'], '/admin/article/add', [\App\Http\Controllers\Admin\ArticleController::class, 'add']);
    //文章添加处理
    Route::match(['get', 'post'], '/article/add/deal', [\App\Http\Controllers\Admin\ArticleController::class, 'addDeal']);

    //采集站点视图
    Route::match(['get','post'], '/admin/site/index', [\App\Http\Controllers\Admin\SiteController::class, 'index']);
    //采集站点状态切换
    Route::match(['get', 'post'], '/site/status/{id}', [\App\Http\Controllers\Admin\SiteController::class, 'status']);
    //添加采集站点,返回视图
    Route::match(['get', 'post'], '/admin/site/add', [\App\Http\Controllers\Admin\SiteController::class, 'add']);
    //处理添加站点
    Route::match(['get', 'post'], '/admin/site/deal', [\App\Http\Controllers\Admin\SiteController::class, 'deal']);
    //返回站点编辑视图
    Route::match(['get', 'post'], '/site/edit/{id}', [\App\Http\Controllers\Admin\SiteController::class, 'edit']);
    //处理修改站点
    Route::match(['get', 'post'], '/site/edit/deal', [\App\Http\Controllers\Admin\SiteController::class, 'editDeal']);
    //站点删除
    Route::match(['get', 'post'], '/site/delete/{id}', [\App\Http\Controllers\Admin\SiteController::class, 'delete']);
    //站点批量删除
    Route::match(['get', 'post'], '/site/delete/all', [\App\Http\Controllers\Admin\SiteController::class, 'all']);

    //返回规则列表视图
    Route::match(['get','post'], '/admin/rule/index', [\App\Http\Controllers\Admin\RuleController::class, 'index']);
    //添加采集规则视图
    Route::match(['get','post'], '/admin/rule/add', [\App\Http\Controllers\Admin\RuleController::class, 'add']);
    //处理添加规则
    Route::match(['get','post'], '/admin/rule/deal', [\App\Http\Controllers\Admin\RuleController::class, 'deal']);
    //规则编辑，返回视图
    Route::match(['get','post'], '/rule/edit/{id}', [\App\Http\Controllers\Admin\RuleController::class, 'edit']);
    //处理规则编辑
    Route::match(['get','post'], '/rule/edit/deal', [\App\Http\Controllers\Admin\RuleController::class, 'editDeal']);
    //规则删除
    Route::match(['get','post'], '/rule/delete/{id}', [\App\Http\Controllers\Admin\RuleController::class, 'delete']);
    //规则批量删除
    Route::match(['get','post'], '/rule/delete/all', [\App\Http\Controllers\Admin\RuleController::class, 'all']);
    //规则测试
    Route::match(['get','post'], '/rule/test/{id}', [\App\Http\Controllers\Admin\RuleController::class, 'test']);

    //返回列表采集视图
    Route::match(['get','post'], '/list/collect/{id}', [\App\Http\Controllers\Admin\CollectController::class, 'list']);
    //处理列表采集
    Route::match(['get','post'], '/admin/list/collect', [\App\Http\Controllers\Admin\CollectController::class, 'listCollect']);
    //返回文章起止ID采集视图
    Route::match(['get', 'post'], '/admin/collect/number', [\App\Http\Controllers\Admin\CollectController::class, 'number']);
    //返回文章列表ID采集视图
    Route::match(['get', 'post'], '/admin/collect/listnum', [\App\Http\Controllers\Admin\CollectController::class, 'listnum']);
    //处理文章ID采集
    Route::match(['get', 'post'], '/admin/collect/numdeal', [\App\Http\Controllers\Admin\CollectController::class, 'numdeal']);

    //返回分类替换视图
    Route::match(['get', 'post'], '/admin/collect/match', [\App\Http\Controllers\Admin\CollectController::class, 'match']);
    //处理匹配分类保存
    Route::match(['get', 'post'], '/admin/match/deal', [\App\Http\Controllers\Admin\CollectController::class, 'matchDeal']);

});

