<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>zzmcs后台登录</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="/static/admin/css/font.css">
    <link rel="stylesheet" href="/static/admin/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="/static/admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/static/admin/js/xadmin.js"></script>

</head>
<body class="login-bg">

<div class="login layui-anim layui-anim-up">
    <div class="message">zzmcs后台登录</div>
    <div id="darkbannerwrap"></div>
    @if(session('error') == '非管理员') <li style="color:red;">年轻人，不讲武德！(你是管理员吗?)</li>@endif
    @if(session('error') == '禁用') <li style="color:red;">账户已被禁用，请联系管理员</li>@endif
    <form class="layui-form" method="post" action="admin/login">
        @csrf
        <input name="username" placeholder="请输入用户名" type="text" class="layui-input"  @if($errors->has('username')) style="color: red" value="{{$errors->first('username')}}" @endif @if(session('error') == '用户名不存在' ) style="color: red" value="{{session('error')}}" @endif>
        <hr class="hr15">
        <input name="password" placeholder="密码" class="layui-input" @if($errors->has('password')) style="color: red" type="text" value="{{$errors->first('password')}}" @else @if(session('error') == '密码不正确' ) style="color: red" type="text" value="{{session('error')}}" @else type="password" @endif @endif>
        <hr class="hr15">
        <input name="captcha" lay-verify="required" placeholder="验证码" type="text" class="layui-input" @if(session('error') == '验证码不正确' ) style="width: 150px; color: red; float: left" value="{{session('error')}}" @else style="width: 150px; float: left" @endif>
        <img width="150px" src="{{url('captcha')}}" alt="captcha" onclick="this.src=this.src+'?'+'id='+Math.random()"
             style="float: right;"/>
        <hr class="hr15">
        <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
        <hr class="hr20">
    </form>
</div>
{{--<script>--}}
{{--    layui.use(['form','layer'],function () {--}}
{{--        var form = layui.form, $ = layui.jquery, layer = layui.layer;--}}
{{--        form.on('submit(login)',function (data) {--}}
{{--            $.ajax({--}}
{{--                type:'post',--}}
{{--                url: 'admin/login',--}}
{{--                dataType:'json',--}}
{{--                headers: {--}}
{{--                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--                },--}}
{{--                data:data.field,--}}
{{--                success: function (data) {--}}
{{--                    console.log(1,data)--}}
{{--                    if(data.status == 1){--}}
{{--                        layer.msg(data.msg,{icon:6,time:1000},function () {--}}
{{--                            window.location.href = '/admin/index/index'--}}
{{--                        });--}}
{{--                    }else{--}}
{{--                        layer.msg(data.msg,{icon:5,time:1000},function () {--}}
{{--                            window.location.href = 'login'--}}
{{--                        });--}}
{{--                    }--}}
{{--                },--}}
{{--                error:function (res) {--}}
{{--                    console.log(2,res);--}}
{{--                }--}}
{{--            })--}}
{{--            return false;--}}
{{--        })--}}
{{--    })--}}
{{--</script>--}}
</body>
</html>
