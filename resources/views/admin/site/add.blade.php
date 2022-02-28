<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>增加站点</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('public.css')
    @include('public.js')
</head>
<body>
<div class="x-body layui-anim layui-anim-up">
    <form class="layui-form">
        <div class="layui-form-item">
            <label class="layui-form-label">
                <span class="x-red">*</span>站点名称
            </label>
            <div class="layui-input-inline">
                <input type="text" name="sitename" required=""
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_pass" class="layui-form-label">
                <span class="x-red">*</span>站点缩写
            </label>
            <div class="layui-input-inline">
                <input type="text" name="siteabb" required="" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
                <span class="x-red">*</span>站点权重
            </label>
            <div class="layui-input-inline">
                <input type="text" name="cid" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
            </label>
            <button  class="layui-btn" lay-filter="add" lay-submit="">
                增加
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
                url:'/admin/site/deal',
                dataType:'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:data.field,
                success:function(res){
                    if(res.code == 200){
                        layer.alert(res.message,{icon:6},function () {
                            // location.replace('/admin/site/index');
                            parent.location.reload(true);
                        });
                    }else{
                        layer.alert(res.message,{icon:5});
                    }
                },
                error:function(msg){
                    var json=JSON.parse(msg.responseText);
                    json = json.errors;
                    for ( var item in json) {
                        for ( var i = 0; i < json[item].length; i++) {
                            layer.msg(json[item][i]);
                            return ; //遇到验证错误，就退出
                        }
                    }
                }
            });
            return false;
        });


    });
</script>
</body>

</html>
