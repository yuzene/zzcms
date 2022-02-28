<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>作者列表页</title>
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
    <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so" method="get" action="/admin/auth/index">
            <div class="layui-input-inline">
                <select name="num">
                    <option value="3" @if($num == 3)  selected="" @endif>3</option>
                    <option value="5" @if($num == 5)  selected="" @endif>5</option>
                    <option value="10" @if($num == 10)  selected="" @endif>10</option>
                </select>
            </div>
            <input type="text" name="authname" @if($authname) value="{{$authname}}" @endif placeholder="请输入作者名" autocomplete="off" class="layui-input">
            <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
    </div>
    <xblock>
        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
{{--        <button class="layui-btn" onclick="x_admin_show('添加作者','{{url('/admin/auth/create')}}',600,400)"><i class="layui-icon"></i>添加</button>--}}
        <span class="x-right" style="line-height:40px">共有作者：{{$count}} 条</span>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            <th>
                <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th>ID</th>
            <th>作者名</th>
            <th>作者KEY</th>
            <th>作者介绍</th>
            <th>作品数量</th>
            <th>操作</th></tr>
        </thead>
        <tbody>
        @foreach($auths as $v)
            <tr>
                <td>
                    <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{$v->id}}'><i class="layui-icon">&#xe605;</i></div>
                </td>
                <td>{{$v->id}}</td>
                <td>{{$v->authname}}</td>
                <td>{{$v->authkey}}</td>
                <td>{{$v->authintro}}...</td>
                <td></td>
                <td class="td-manage">
                    <a title="编辑" onclick="x_admin_show('添加用户','{{url('/auth/edit/')}}/{{$v->id}}',600,400)">
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
    <div class="page">
        {{--        {!!$users->appends($num)->render() !!}--}}
        {{ $auths->links('vendor.pagination.tailwind')  }}

    </div>

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

    /*作者-删除*/
    function member_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.post('/auth/delete/'+id, {"_token":"{{csrf_token()}}"},function (data) {
                if(data.status == 1){
                    $(obj).parents("tr").remove();
                    layer.msg(data.message,{icon:6,time:1000});
                }else{
                    layer.msg(data.message,{icon:6,time:1000});
                }
            });
        });
    }
    /*多个作者-删除*/
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
            $.get('/auth/delAll',{"_token":"{{csrf_token()}}",'ids':ids},function(data){
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
