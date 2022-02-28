<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>文章列表</title>
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
{{--        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>--}}
        <button class="layui-btn" onclick="x_admin_show('添加站点','{{url('/admin/site/add')}}',600,400)"><i class="layui-icon"></i>添加</button>
        <span class="x-right" style="line-height:40px">规则数量：{{$count}} 个</span>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            <th>
                <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th>ID</th>
            <th>站点名称</th>
            <th>站点标识(缩写)</th>
            <th>站点权重</th>
            <th>创建时间</th>
            <th>最后一次修改时间</th>
            <th>文章数量</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($sites as $v)
            <tr>
                <td>
                    <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{$v->id}}'><i class="layui-icon">&#xe605;</i></div>
                </td>
                <td>{{$v->id}}</td>
                <td>{{$v->sitename}}</td>
                <td>{{$v->siteabb}}</td>
                <td>{{$v->cid}}</td>
                <td>{{$v->created_at}}</td>
                <td>{{$v->updated_at}}</td>
                <td>{{$v->total}}</td>
                <td>
                @if($v->sitedisable == 1)
                    <a href="/site/status/{{$v->id}}"><span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span></a>
                @else
                    <a href="/site/status/{{$v->id}}"><span class="layui-btn layui-btn-danger layui-btn-mini">已禁用</span></a>
                @endif
                </td>
                <td class="td-manage">
                    <a onclick="x_admin_show('编辑站点','{{url('/site/edit/')}}/{{$v->id}}',600,400)">
                        <i class="layui-icon">&#xe642;</i>
                    </a>
                    <a title="删除" onclick="member_del(this,{{$v->id}})" href="javascript:;">
                        <i class="layui-icon">&#xe640;</i>
                    </a>
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
            $.post('/site/delete/'+id, {"_token":"{{csrf_token()}}"},function (data) {
                if(data.status == 1){
                    $(obj).parents("tr").remove();
                    layer.msg(data.message,{icon:6,time:1000});
                }else{
                    layer.msg(data.message,{icon:5,time:1000});
                }
            });
        });
    }
    /*多个站点-删除*/
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
            $.get('/site/delete/all',{"_token":"{{csrf_token()}}",'ids':ids},function(data){
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
