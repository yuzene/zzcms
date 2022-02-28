<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>增加规则</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('public.css')
    @include('public.js')
    <style>
        .layui-input{
            width: 400px;
        }
    </style>
</head>
<body>
<div class="x-body layui-anim layui-anim-up">
    <form class="layui-form">
        <input type="hidden" name="id" value="{{$rule->id}}">
        <input type="hidden" name="ruleauth" value="{{ session('user_id') }}">
        <div class="layui-form-item">
            <label class="layui-form-label">
                <span class="x-red">*</span>规则名称
            </label>
            <div class="layui-input-inline">
                <input type="text" name="rulename" required=""
                       autocomplete="off" class="layui-input" value="{{$rule->rulename}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_pass" class="layui-form-label">
                <span class="x-red">*</span>所属站点
            </label>
            <div class="layui-input-inline">
                <select name="sid">
                    @foreach($sites as $v)
                        <option value="{{ $v->id }}" @if($rule->sid == $v->id)  selected="selected" @endif>{{ $v->sitename }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
                <span class="x-red">*</span>列表页地址
            </label>
            <div class="layui-input-inline">
                <input type="text" name="list" autocomplete="off" class="layui-input" required="" value="{{$rule->list}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
                <span class="x-red">*</span>列表页文章ID
            </label>
            <div class="layui-input-inline">
                <input type="text" name="list_article_id" autocomplete="off" class="layui-input" required="" value="{{$rule->list_article_id}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
                <span class="x-red">*</span>列表页文章标题
            </label>
            <div class="layui-input-inline">
                <input type="text" name="list_article_name" autocomplete="off" class="layui-input" required="" value="{{$rule->list_article_name}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
                <span class="x-red">*</span>文章地址
            </label>
            <div class="layui-input-inline">
                <input type="text" name="info" autocomplete="off" class="layui-input" required="" value="{{$rule->info}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
                <span class="x-red">*</span>文章标题
            </label>
            <div class="layui-input-inline">
                <input type="text" name="info_article_title" autocomplete="off" class="layui-input" required="" value="{{$rule->info_article_title}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
                <span class="x-red">*</span>文章作者
            </label>
            <div class="layui-input-inline">
                <input type="text" name="info_article_auth" autocomplete="off" class="layui-input" required="" value="{{$rule->info_article_auth}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
                <span class="x-red">*</span>文章分类
            </label>
            <div class="layui-input-inline">
                <input type="text" name="info_article_sort" autocomplete="off" class="layui-input" required="" value="{{$rule->info_article_sort}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
                <span class="x-red">*</span>文章内容
            </label>
            <div class="layui-input-inline">
                <input type="text" name="info_article_content" autocomplete="off" class="layui-input" required="" value="{{$rule->info_article_content}}">
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
                url:'/rule/edit/deal',
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
