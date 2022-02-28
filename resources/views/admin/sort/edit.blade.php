<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.0</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    @include('public.css')
    @include('public.js')
</head>

<body>
<div class="x-body">
    <form class="layui-form">
        <div class="layui-form-item">
            <label for="L_email" class="layui-form-label">
                <span class="x-red">*</span>父级分类
            </label>
            <div class="layui-input-inline">
                <select name="cid">
                    <option value="0">==顶级分类==</option>
                    @foreach($sorts as $v)
                        <option value="{{ $v->id }}">{{ $v->sortname }}</option>
                    @endforeach
                </select>
            </div>
            <div class="layui-form-mid layui-word-aux">
                <span class="x-red">*</span>
            </div>
        </div>
        <input type="hidden" id="id" name="id" required="" value="{{$sort->id}}">
        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">
                <span class="x-red">*</span>分类名称
            </label>
            <div class="layui-input-inline">
                <input type="text" id="L_username" name="sortname" required=""
                       autocomplete="off" class="layui-input" value="{{$sort->sortname}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_catetitle" class="layui-form-label">
                <span class="x-red">*</span>分类KEY
            </label>
            <div class="layui-input-inline">
                <input type="text" id="L_catetitle" name="key" required=""
                       autocomplete="off" class="layui-input" value="{{$sort->key}}">
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
        //设置父级分类
        if({{$sort->cid}}){
            $("[lay-value='{{ $sort->cid }}']").addClass("layui-this");
            $("[lay-value= 0]").removeClass("layui-this");
        }
        //监听提交
        form.on('submit(edit)', function(data){
            $.ajax({
                method:'POST',
                url:'/admin/edit/deal',
                dataType:'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:data.field,
                success:function(data){
                    if(data.status == 1){
                        layer.alert(data.message,{icon:6},function () {
                            parent.location.reload(true);
                        });
                    }else{
                        layer.alert(data.message,{icon:5});
                    }
                },
                error:function (data) {
                    //弹层错误信息
                }
            });
            return false;
        });

    });
</script>
</body>

</html>
