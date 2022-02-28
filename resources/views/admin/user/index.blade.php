<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>后台用户列表页</title>
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
        <form class="layui-form layui-col-md12 x-so" method="get" action="/user/list/page">
            <div class="layui-input-inline">
                <select name="num" lay-filter="aihao">
                        <option value="3" @if($num == 3)  selected="" @endif>3</option>
                        <option value="5" @if($num == 5)  selected="" @endif>5</option>
                        <option value="10" @if($num == 10)  selected="" @endif>10</option>
                </select>
            </div>
            <input type="text" name="username" @if($val) value="{{$val}}" @endif placeholder="请输入用户名" autocomplete="off" class="layui-input">
            <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
    </div>
    <xblock>
        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
        <button class="layui-btn" onclick="x_admin_show('添加用户','{{url('/user/add')}}',600,400)"><i class="layui-icon"></i>添加</button>
        <span class="x-right" style="line-height:40px">用户数量：{{$count}} 个</span>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            <th>
                <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th>ID</th>
            <th>用户名</th>
            <th>邮箱</th>
            <th>注册ip</th>
            <th>最后登录ip</th>
            <th>注册时间</th>
            <th>最后登录时间</th>
            <th>状态</th>
            <th>操作</th></tr>
        </thead>
        <tbody>
        @foreach($users as $v)
            <tr>
                <td>
                    <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{$v->id}}'><i class="layui-icon">&#xe605;</i></div>
                </td>
                <td>{{$v->id}}</td>
                <td>{{$v->username}}</td>
                <td>{{$v->email}}</td>
                <td>{{$v->registerip}}</td>
                <td>{{$v->loginip}}</td>
                <td>{{$v->created_at}}</td>
                <td>{{$v->updated_at}}</td>
                <td class="td-status">
                  @if($v->status == 1)
                        <a href="/user/status/{{$v->id}}"><span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span></a>
                  @else
                        <a href="/user/status/{{$v->id}}"><span class="layui-btn layui-btn-danger layui-btn-mini">已禁用</span></a>
                  @endif
                </td>
                <td class="td-manage">
                    @if($v->status == 1)
                        <a  href="/user/status/{{$v->id}}"  title="禁用">
                            <i class="layui-icon">&#xe601;</i>
                        </a>
                    @else
                        <a  href="/user/status/{{$v->id}}"  title="启用">
                            <i class="layui-icon">&#xe62f;</i>
                        </a>
                    @endif
                    <a title="编辑" onclick="x_admin_show('添加用户','{{url('/user/edit/')}}/{{$v->id}}',600,400)">
                        <i class="layui-icon">&#xe642;</i>
                    </a>
                        <a title="编辑" onclick="x_admin_show('修改密码','{{url('/user/pass/')}}/{{$v->id}}',600,400)">
                        <i class="layui-icon">&#xe631;</i>
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
        {{ $users->links('vendor.pagination.tailwind')  }}

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

    /*用户-删除*/
    function member_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.post('/user/delete/'+id, {"_token":"{{csrf_token()}}"},function (data) {
                if(data.status == 1){
                    $(obj).parents("tr").remove();
                    layer.msg(data.message,{icon:6,time:1000});
                }else{
                    layer.msg(data.message,{icon:6,time:1000});
                }
            });
        });
    }
    /*多个用户-删除*/
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
            $.get('/user/delAll',{"_token":"{{csrf_token()}}",'ids':ids},function(data){
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
