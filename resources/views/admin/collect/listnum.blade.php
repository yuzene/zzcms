<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>文章ID采集</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('public.css')
    @include('public.js')
</head>
<body>
<div class="x-body layui-anim layui-anim-up">
    <form class="layui-form" action="/admin/collect/numdeal">
        @csrf
        <div class="layui-form-item">
            <label class="layui-form-label">
                <span class="x-red">*</span>选用规则
            </label>
            <div class="layui-input-inline">
                <select name="rid">
                    @foreach($rules as $v)
                        <option value="{{ $v->id }}">{{ $v->rulename }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_pass" class="layui-form-label">
                <span class="x-red">*</span>文章ID
            </label>
            <div class="layui-input-inline">
               <textarea name="articleIds" style="width: 600px; height: 300px;" placeholder="文章号以英文逗号隔开"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <a href="/admin/collect/number"><input type="radio" name="way" value="startend" title="以起止文章号采集"></a>
            <input type="radio" name="way" value="list" title="文章号列表形式采集" checked>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
            </label>
            <button  class="layui-btn" lay-filter="add" lay-submit="">
                开始采集
            </button>
        </div>
    </form>
</div>
</body>

</html>
