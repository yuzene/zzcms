<div class="left-nav">
    <div id="side-nav">
        <ul id="nav">
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe6b8;</i>
                    <cite>用户管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="{{ url('/user/list/page') }}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>用户列表</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="{{ url('/user/add') }}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>添加用户</cite>
                        </a>
                    </li >
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe699;</i>
                    <cite>分类管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="{{ url('/sort/list') }}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>分类列表</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="{{ url('/admin/sort/create') }}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>添加分类</cite>
                        </a>
                    </li >
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe732;</i>
                    <cite>作者管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="{{ url('/admin/auth/index') }}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>作者列表</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="{{ url('/admin/auth/create') }}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>添加作者</cite>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe757;</i>
                    <cite>文章管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="{{ url('/admin/article/index') }}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>文章列表</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="{{ url('/admin/article/add') }}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>添加文章</cite>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe719;</i>
                    <cite>采集管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="{{ url('/admin/site/index') }}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>采集站点</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="{{ url('/admin/rule/index') }}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>采集规则</cite>
                        </a>
                    </li>
                    <li>
                        <a _href="{{ url('/admin/collect/number') }}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>ID采集</cite>
                        </a>
                    </li>
                    <li>
                        <a _href="{{ url('/admin/collect/match') }}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>分类替换</cite>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe6ae;</i>
                    <cite>网站配置管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="{{ url('admin/config/create') }}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>添加网站配置</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="{{ url('admin/config') }}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>网站配置列表</cite>
                        </a>
                    </li >
                </ul>
            </li>
        </ul>
    </div>
</div>
