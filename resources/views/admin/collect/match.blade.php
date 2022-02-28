<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>分类替换</title>
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
                <span class="x-red">请参考文本框格式仅匹配以下分类,不按格式会出现无法预料的错误</span><br/>
            @foreach($sorts as $sort)
                @if($sort->cid != 0)
                    {{$sort->id}}.{{$sort->sortname}}
                @endif
            @endforeach
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
                <span class="x-red">*</span>替换规则
            </label>
            <div class="layui-input-inline">
                    <textarea name="match" style="width: 600px; height: 300px;" placeholder="[
                '本站分类名称1'=> ['需要匹配的分类1', '需要匹配的分类2', ...]
                '本站分类名称2'=> ['需要匹配的分类1', '需要匹配的分类2', ...]
                '本站分类名称3'=> ['需要匹配的分类1', '需要匹配的分类2', ...]
                ......
                ]">{{$match??''}}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
            </label>
            <button  class="layui-btn" lay-filter="save" lay-submit="">
                保存
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
        form.on('submit(save)', function(data){
            $.ajax({
                type:'POST',
                url:'/admin/match/deal',
                dataType:'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:data.field,
                success:function(res){
                    if(res.code == 200){
                       console.log(res.data);
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
