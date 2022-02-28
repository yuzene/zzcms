<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>规则列表</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    @include('public.css')
    @include('public.js')
</head>

<body class="layui-anim layui-anim-up">
<div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">演示</a>
        <a>
          <cite>导航元素</cite></a>
      </span>
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
</div>
<div class="x-body">
    <xblock>
        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
        <button class="layui-btn" onclick="x_admin_show('添加规则','{{url('/admin/rule/add')}}')"><i class="layui-icon"></i>添加</button>
        <span class="x-right" style="line-height:40px">共有规则：{{$count}} 个</span>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            <th>
                <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th>ID</th>
            <th>规则名称</th>
            <th>所属站点</th>
            <th>创建人</th>
            <th>创建时间</th>
            <th>最后更新时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rules as $v)
            <tr>
                <td>
                    <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{$v->id}}'><i class="layui-icon">&#xe605;</i></div>
                </td>
                <td>{{$v->id}}</td>
                <td>{{$v->rulename}}</td>
                <td>{{$v->site_name}}</td>
                <td>{{$v->ruleauth}}</td>
                <td>{{$v->created_at}}</td>
                <td>{{$v->updated_at}}</td>
                <td class="td-manage">
                    <button class="layui-btn layui-btn-sm layui-btn-warm" onclick="x_admin_show('编辑','{{url('/rule/edit/')}}/{{$v->id}}')">编辑</button>
                    <a title="删除" onclick="member_del(this,{{$v->id}})" href="javascript:;">
                        <button class="layui-btn layui-btn-sm layui-btn-danger" >删除</button>
                    </a>
                    <button class="layui-btn layui-btn-sm" onclick="x_admin_show('执行测试','{{url('/rule/test/')}}/{{$v->id}}')">测试</button>
                    <a class="layui-btn layui-btn-sm" href="/list/collect/{{$v->id}}">采集</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<script>
    layui.use('laydate', function(){
        var laydate = layui.laydate;

        //执行一个laydate实例
        laydate.render({
            elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
            elem: '#end' //指定元素
        });
    });

    /*文章-删除*/
    function member_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.post('/rule/delete/'+id, {"_token":"{{csrf_token()}}"},function (data) {
                if(data.status == 1){
                    $(obj).parents("tr").remove();
                    layer.msg(data.message,{icon:6,time:1000});
                }else{
                    layer.msg(data.message,{icon:6,time:1000});
                }
            });
        });
    }
    /*多个文章-删除*/
    function delAll (argument) {

        //先定义一个空数组，等下用来获取所有被选中的id
        var ids = [];
        //获取所有id并调用each的闭包函数遍历push给ids
        $(".layui-form-checked").not(".header").each(function (i,v) {
            var u = $(v).attr('data-id');
            ids.push(u);
        })

        layer.confirm('确认要删除吗？',function(index){
            //捉到所有被选中的，发异步进行删除
            $.get('/rule/delete/all',{"_token":"{{csrf_token()}}",'ids':ids},function(data){
                if(data.status == 1){
                    $(".layui-form-checked").not('.header').parents('tr').remove();
                    layer.msg(data.message,{icon:6,time:1000});
                }
            });

        });
    }
</script>
</body>

</html>
