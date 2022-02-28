<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>采集任务</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    @include('public.css')
    @include('public.js')
</head>
<body>
<div class="x-body layui-anim layui-anim-up">
    <form class="layui-form" action="/admin/list/collect" method="post">
        @csrf
        <input type="hidden" name="id" value="{{$rule->id}}">
        <div class="layui-form-item">
            <label class="layui-form-label">
                <span class="x-red">*</span>使用规则
            </label>
            <div class="layui-input-inline">
                <input type="text" readonly name="rulename" class="layui-input" value="{{$rule->rulename}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_pass" class="layui-form-label">
                <span class="x-red">*</span>开始页码
            </label>
            <div class="layui-input-inline">
                <input type="text" name="pagemin" lay-verify="number" placeholder="规则没有页码请留空" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
                <span class="x-red">*</span>结束页码
            </label>
            <div class="layui-input-inline">
                <input type="text" name="pagemax" lay-verify="number" placeholder="规则没有页码请留空" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
            </label>
            <input type="submit" class="layui-btn" value="采集">
        </div>
    </form>
</div>
<script>
    layui.use(['form', 'layedit', 'laydate'], function (){
        var form = layui.form;
    })
</script>
</body>

</html>
