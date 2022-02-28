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
    <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so" method="get" action="/admin/article/index">
            <div class="layui-input-inline">
                <select name="num" lay-filter="aihao">
                    <option value="10" @if($num == 10)  selected="" @endif>10</option>
                    <option value="30" @if($num == 30)  selected="" @endif>30</option>
                    <option value="50" @if($num == 50)  selected="" @endif>50</option>
                </select>
            </div>
            <input type="text" name="article_name" @if($article_name) value="{{$article_name}}" @endif placeholder="请输入文章名" autocomplete="off" class="layui-input">
            <input type="text" name="article_auth" @if($article_auth) value="{{$article_auth}}" @endif placeholder="请输入作者名" autocomplete="off" class="layui-input">
            <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
    </div>
    <xblock>
        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
{{--        <button class="layui-btn" onclick="x_admin_show('添加文章','{{url('/admin/article/add')}}',600,400)"><i class="layui-icon"></i>添加</button>--}}
        <span class="x-right" style="line-height:40px">共有文章：{{$count}} 篇</span>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            <th>
                <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th>ID</th>
            <th>文章标题</th>
            <th>文章作者</th>
            <th>文章分类</th>
            <th>文章内容</th>
            <th>源站</th>
            <th>总点击</th>
            <th>月点击</th>
            <th>周点击</th>
            <th>日点击</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($articles as $v)
            <tr>
                <td>
                    <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{$v->id}}'><i class="layui-icon">&#xe605;</i></div>
                </td>
                <td>{{$v->id}}</td>
                <td>{{$v->article_name}}</td>
                <td>{{$v->article_auth_name}}</td>
                <td>{{$v->article_sort_name}}</td>
                <td>{{$v->content}}</td>
                <td>{{$v->source_name}}</td>
                <td>{{$v->allvisit}}</td>
                <td>{{$v->monthvisit}}</td>
                <td>{{$v->weekvisit}}</td>
                <td>{{$v->dayvisit}}</td>
                <td class="td-manage">
{{--                    <a title="编辑" onclick="x_admin_show('编辑文章','{{url('/article/edit/')}}/{{$v->id}}')">--}}
{{--                        <i class="layui-icon">&#xe642;</i>--}}
{{--                    </a>--}}
                        <a title="编辑" href="{{ url('/article/edit/') }}/{{$v->id}}">
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
        {{ $articles->links('vendor.pagination.tailwind')  }}
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

    /*文章-删除*/
    function member_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.post('/article/delete/'+id, {"_token":"{{csrf_token()}}"},function (data) {
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
            $.get('/article/delete/all',{"_token":"{{csrf_token()}}",'ids':ids},function(data){
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
