<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>编辑作者</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('public.css')
    @include('public.js')
</head>
<body>
<div class="x-body layui-anim layui-anim-up">
    <form class="layui-form">
        <input type="hidden" name="id" value="{{$auth->id}}">
        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">
                <span class="x-red">*</span>作者名
            </label>
            <div class="layui-input-inline">
                <input type="text" name="authname" required=""
                       autocomplete="off" value="{{$auth->authname}}" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">
                <span class="x-red">*</span>作者KEY
            </label>
            <div class="layui-input-inline">
                <input type="text" name="authkey" required=""
                       autocomplete="off" class="layui-input" value="{{$auth->authkey}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">
                <span class="x-red">*</span>作者简介
            </label>
            <div class="layui-input-inline">
                <textarea class="layui-textarea" style="width:300px;" name="authintro">{{$auth->authintro}}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
            </label>
            <button  class="layui-btn" lay-filter="edit" lay-submit="">
                修改
            </button>
        </div>
    </form>
</div>
<script>
    layui.use(['form','layer'], function(){
        $ = layui.jquery;
        var form = layui.form
            ,layer = layui.layer;

        //监听提交
        form.on('submit(edit)', function(data){
            $.ajax({
                type:'POST',
                url:'/auth/edit/deal',
                dataType:'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:data.field,
                success:function(res){
                    if(res.code == 200){
                        layer.alert(res.message,{icon:6},function () {
                            parent.location.reload(true);
                        });
                    }else{
                        layer.alert(res.message,{icon:5});
                    }
                },
                error:function(msg){

                }
            });
            return false;
        });
    });
</script>
</body>

</html>
