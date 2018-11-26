@extends('admin.master')
@section('content')
    <style>

        .slimScrollDiv > .sidebar-collapse {
            overflow: visible;
        }

        .functional-menu {
            position: absolute;
            left: 40px;
            top: 0;
            width: 80px;
            background: transparent;
        }

        .functional-menu:hover .tit {
            background: #eaeaea;
        }

        .functional-menu:hover .menu-wrap {
            display: block;
        }

        .functional-menu .tit {
            display: block;
            text-align: center;

        }

        .functional-menu .menu-wrap {
            margin-top: 2px;
            z-index: 99;
            background: #fff;
            width: 942px;
            min-height: 600px;
            padding: 20px;
            border: 1px solid #eee;
            font-size: 0;
            display: none;
        }

        .functional-menu .menu-wrap .menu-section {
            display: inline-block;
            vertical-align: top;
            width: 150px;
            font-size: 14px;
            text-align: center;
            font-size: 14px;
            margin-top: 20px;
            border-radius: 4px;
        }

        .functional-menu .menu-wrap .menu-section:hover {
            background: #eaeaea;
        }

        .functional-menu .menu-wrap .menu-section .title {
            font-weight: bold;
        }

        .functional-menu a {
            color: inherit;
        }

        .functional-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
            line-height: 30px;
            padding-bottom: 20px;
        }

        .functional-menu ul li:hover {
            background: #1ab394;
            color: #fff;
        }

        nav.page-tabs {
            margin-left: 120px;
        }

        body.mini-navbar .navbar-default .nav-item > li {
            padding-left: 50px;
            height: 42px;
        }

        /* 顶部导航 */
        .side-nav-wrap .nav > li.active {
            border-left-color: {{$frame['css_setting']['top_color'] or ''}};
        }

        .index-hd {
            background-color: {{$frame['css_setting']['top_color'] or ''}};
        }

        .navbar-static-side {
            /* 以下  左侧导航 */
            background: {{$frame['css_setting']['left_color'] or ''}};
        }

        .fixed-sidebar.mini-navbar .nav li:hover > .nav-second-level {
            background-color: {{$frame['css_setting']['left_alert'] or ''}};
        }

        .navbar-default .nav > li:hover {
            background-color: rgba(0, 0, 0, 0.1);
        }

        .navbar-default .nav > li:hover > a {
            color: #fff;
        }

        .navbar-default .nav > li > a:hover, .navbar-default .nav > li > a:focus {
            background-color: transparent;
        }

        .nav > li.active {
            background-color: rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 350px) {
            body.mini-navbar .navbar-default .nav-item > li {
                visibility: none;
            }

            .index-hd-nav {
                visibility: none;
            }
        }

        @media (max-width: 768px) {
            .index-hd-nav-item {
                padding: 0;
            }

            .index-hd-right > *:not(:last-child) {
                display: none;
            }
        }

    </style>
    <div id="wrapper">
        <!-- 顶部导航 -->
        <div class="index-hd">
            <div class="index-hd-logo">
                FD
            </div>
            <div class="index-hd-switch">
                <div class="navbar-minimalize minimalize-styl-2 "
                     href="javascript:;">
                    <i class="fa fa-bars"></i>
                    <i class="fa fa-chevron-left"></i>
                </div>
            </div>

            <ul class="index-hd-nav"
                id="top_nav_wrap">
                @foreach($powers as $node)
                    @if(!empty($node['powers']))
                        @if($node['powers'][0]['id']==10425)
                            <li class="index-hd-nav-item active"><i class="fa fa {{$node['powers'][0]['icon']}}"></i>{!! $node['powers'][0]['title'] !!}</li>
                        @else
                            <li class="index-hd-nav-item"><i class="fa fa {{$node['powers'][0]['icon']}}"></i>{!! $node['powers'][0]['title'] !!}</li>
                        @endif

                    @endif
                @endforeach
            </ul>

            <!-- 退出按钮 -->
            <div class="index-hd-right">
                <li class="dropdown index-hd-item">
                    <a class="dropdown-toggle hd-title count-info"
                       data-toggle="dropdown"
                       aria-expanded="false"
                       href="#">
                        <i class="fa fa-envelope"></i> <span class="label label-warning">16</span>
                    </a>
                    <ul class="dropdown-menu dropdown-messages hd-list">
                        <li class="m-t-xs">
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="{{url('image.png')}}">
                                </a>
                                <div class="media-body">
                                    <small class="pull-right">46小时前</small>
                                    <strong>小四</strong> 这个在日本投降书上签字的军官，建国后一定是个不小的干部吧？
                                    <br>
                                    <small class="text-muted">3天前 2014.11.8</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="{{url('image.png')}}">
                                </a>
                                <div class="media-body ">
                                    <small class="pull-right text-navy">25小时前</small>
                                    <strong>国民岳父</strong> 如何看待“男子不满自己爱犬被称为狗，刺伤路人”？——这人比犬还凶
                                    <br>
                                    <small class="text-muted">昨天</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="mailbox.html" data-index="88">
                                    <i class="fa fa-envelope"></i> <strong> 查看所有消息</strong>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="index-hd-item dropdown">
                    <a class="dropdown-toggle hd-title count-info"
                       data-toggle="dropdown"
                       aria-expanded="false"
                       href="#">
                        <i class="fa fa-bell"></i> <span class="label label-danger">6</span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts hd-list">
                        <li>
                            <a href="mailbox.html">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> 您有16条未读消息
                                    <span class="pull-right text-muted small">4分钟前</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="profile.html">
                                <div>
                                    <i class="fa fa-qq fa-fw"></i> 3条新回复
                                    <span class="pull-right text-muted small">12分钟钱</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a class="J_menuItem" href="notifications.html" data-index="89">
                                    <strong>查看所有 </strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="index-hd-item" onclick="viewInFullScreen()">
                    <a class="dropdown-toggle count-info hd-title"
                       data-toggle="dropdown"
                       href="#">
                        <i class="fa fa-arrows-alt"></i>
                    </a>
                </li>
                <li class="index-hd-item user">
                    <a class="dropdown-toggle count-info hd-title"
                        data-toggle="dropdown"
                        aria-expanded="false"
                        href="#">
                        <span >
                            @if(session('admin.picpath'))
                                <img id="images"
                                     src="{{session('admin.picpath')}}"
                                     style="width:25px;height:25px;margin-right:10px;border-radius:50%;">
                            @else
                                <img id="images"
                                     src="{{url('image.png')}}"
                                     style="width:25px;height:25px;margin-right:10px;border-radius:50%;">
                            @endif
                        </span>
                        <span>{{session('admin.username')}}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts hd-list">
                        <li>
                            {{--<a target="_self"  class="J_iframe" href="{{url('/admin/admin/userCenter')}}">--}}
                            <a class="J_menuItem"  href="{{url('/admin/admin/userCenter')}}">
                                <div>设置</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{url('admin/logout')}}">
                                <div>退出</div>
                            </a>
                        </li>
                    </ul>
                </li>
            </div>
        </div>

        <!--左侧导航开始-->
        <nav class="navbar-default navbar-static-side"
             role="navigation">
            <div class="nav-close"><i class="fa fa-times-circle"></i>
            </div>
            <div class="sidebar-collapse">
                <div class="side-nav-wrap"
                     id="side-menu">
                    @foreach($powers as $node)
                        @if(!empty($node['powers']))
                            {{--<ul class="nav nav-item active">--}}
                            @if($node['powers'][0]['id']==10425)
                                <ul class="nav nav-item active">
                                    @else
                                        <ul class="nav nav-item">
                                            @endif
                                            @foreach ($node['childrens'] as $nodeVal)
                                                <li>
                                                    @if($nodeVal['name']=='a')
                                                        <a href="#">
                                                            <i class="fa fa {{$nodeVal['icon']}}"></i>
                                                            <span class="nav-label">{{$nodeVal['title']}}</span>
                                                        </a>
                                                    @else
                                                        <a href="{{url($nodeVal['name'])}}">
                                                            <i class="fa fa {{$nodeVal['icon']}}"></i>
                                                            <span class="nav-label">{{$nodeVal['title']}}</span>
                                                        </a>
                                                    @endif
                                                    @if(!empty($nodeVal))
                                                        @foreach($nodeVal['children'] as $childrens)
                                                            @if(!empty($childrens))
                                                                <ul class="nav nav-second-level">
                                                                    <li>
                                                                        <a class="J_menuItem"
                                                                           href="{{url($childrens['name'])}}">{{$childrens['title']}}
                                                                        </a>
                                                                        @if(!empty($childrens['children']))
                                                                            @foreach($childrens['children'] as $ch)
                                                                                <ul class="nav nav-second-level">
                                                                                    <li style="margin-left:15px;"><a class="J_menuItem"
                                                                                                                     href="{{url($ch['name'])}}"
                                                                                                                     style="color: #48A7CE;">{{$ch['title']}}</a></li>
                                                                                </ul>
                                                                            @endforeach
                                                                        @endif
                                                                    </li>
                                                                </ul>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                @endif
                                @endforeach
                                <!-- 静态内容  展示效果用  -->
                </div>
            </div>
        </nav>
        <!--左侧导航结束-->
        <!--右侧部分开始-->
        <div id="page-wrapper"
             class="gray-bg dashbard-1">
            <div class="row content-tabs">
                <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i>
                </button>
                <div class="functional-menu">
                    <a href="javascript:;"
                       class="J_menuTab tit"
                       data-id="index_v1.html">地图</a>
                    {{--<!--                    <div class="menu-wrap">-->--}}
                    {{--<!--                        @foreach($powers as $node)-->--}}
                    {{--<!--                        <div class="menu-section">-->--}}
                    {{--<!--                            <p class="title">{{$node['powers'][0]['title']}}</p>-->--}}
                    {{--<!--                            <ul class="menu-list">-->--}}
                    {{--<!--                                @foreach($node['childrens'] as $childrens)-->--}}
                    {{--<!--                                    <li><a href="{{url($childrens['name'])}}"  class="J_menuItem">{{$childrens['title']}}</a></li>-->--}}
                    {{--<!--                                @endforeach-->--}}
                    {{--<!--                            </ul>-->--}}
                    {{--<!--                        </div>-->--}}
                    {{--<!--                        @endforeach-->--}}
                    {{--<!--                    </div>-->--}}
                </div>
                <nav class="page-tabs J_menuTabs">
                    <div class="page-tabs-content">
                        <a href="javascript:;"
                           class="active J_menuTab"
                           data-id="index_v1.html">首页</a>
                    </div>
                </nav>
                <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i>
                </button>
                <div class="btn-group roll-nav roll-right">
                    <button class="dropdown J_tabClose"
                            data-toggle="dropdown">关闭操作<span class="caret"></span>
                    </button>
                    <ul role="menu"
                        class="dropdown-menu dropdown-menu-right">

                        <li class="J_tabCloseAll"><a>关闭全部选项卡</a>
                        </li>
                        <li class="J_tabCloseOther"><a>关闭其他选项卡</a>
                        </li>
                    </ul>
                </div>
            <!-- <a href="{{url('admin/logout')}}"
               class="roll-nav roll-right J_tabExit"><i
                        class="fa fa fa-sign-out"></i> 退出</a> -->
            </div>
            <div class="row J_mainContent"
                 id="content-main">
                @if(session('admin.rid')==17||session('admin.rid')==18)
                    <iframe class="J_iframe"
                            name="iframe0"
                            width="100%"
                            height="100%"
                            src="{{url('admin/artificial/index')}}"
                            frameborder="0"
                            data-id="index_v1.html"
                            seamless></iframe>
                @else
                    <iframe class="J_iframe"
                            name="iframe0"
                            width="100%"
                            height="100%"
                            src="index_v1"
                            frameborder="0"
                            data-id="index_v1.html"
                            seamless></iframe>
                @endif
            </div>
            {{--
            <div class="footer">--}}
            {{--
            <div class="pull-right">&copy; 2014-2015 <a href="#"
                                                        target="_blank">zihan's--}}
            {{--blog</a>--}}
            {{--
        </div>
        --}}
            {{--
        </div>
        --}}
        </div>
        <!--右侧部分结束-->
    {{--————————————————————————————————————————————————————————————————--}}
    <!--右侧边栏开始-->
        <div id="right-sidebar">
            <div class="sidebar-container">
                <ul class="nav nav-tabs navs-3">
                    <li class="active">
                        <a data-toggle="tab"
                           href="#tab-3">
                            <i class="fa fa-gear"></i>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tab-3"
                         class="tab-pane active">
                        <div class="sidebar-title">
                            <h3><i class="fa fa-gears"></i> 设置</h3>
                        </div>
                        <div class="setings-item">
                            {{--@foreach($system as $value)--}}
                            <span>
                            上传CDN
                        </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox"
                                           name="collapsemenu"
                                           class="onoffswitch-checkbox"
                                           id="example">
                                    <label class="onoffswitch-label"
                                           for="example">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                            {{--@endforeach--}}
                            <span>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
