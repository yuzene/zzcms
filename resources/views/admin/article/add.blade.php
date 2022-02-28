<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>文章修改</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('public.css')
    @include('public.js')
    <script type="text/javascript" src="/static/admin/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" src="/static/admin/ueditor/ueditor.all.js"></script>
    <style>
        .layui-input{
            width: 800px;
        }
    </style>
</head>
<body style="font-size: 5px;">
<div class="x-body layui-anim layui-anim-up">
    <form class="layui-form">
        <div class="layui-form-item" style="margin: 2px">
            <label class="layui-form-label" for="article_name">
                <span class="x-red">*</span>文章标题
            </label>
            <div class="layui-input-inline">
                <input type="text" name="article_name" required="" id="article_name"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item" style="margin: 2px">
            <label for="article_auth" class="layui-form-label">
                <span class="x-red">*</span>作者
            </label>
            <div class="layui-input-inline">
                <input type="text" name="article_auth" id="article_auth" required="" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="article_sort" class="layui-form-label">
                <span class="x-red">*</span>文章分类
            </label>
            <div class="layui-input-inline" style="position:relative;   z-index:99999; ">
                <select name="article_sort" id="article_sort">
                    @foreach($sorts as $sort)
                        <option @if($sort->cid == 0) disabled="disabled" @endif value="{{$sort->id}}">{{$sort->sortname}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="Content" class="layui-form-label">
                <span class="x-red">*</span>文章内容
            </label>
            <div class="layui-input-inline">
                <script id="container" name="content" type="text/plain" style="width: 800px;"></script>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
            </label>
            <button  class="layui-btn" lay-filter="add" lay-submit="">
                添加
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
        form.on('submit(add)', function(data){
            $.ajax({
                type:'POST',
                url:'/article/add/deal',
                dataType:'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:data.field,
                success:function(res){
                    if(res.code == 200){
                        layer.alert(res.message,{icon:6},function () {
                            location.replace('/admin/article/index');
                        });
                    }else if(res.code == 500){
                        layer.msg(res.message,{icon:5,time:1500});
                    } else{
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
<!-- 实例化百度富文本编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor('container');
</script>
</body>
</html>
