<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title>{{time()}}</title>
    <meta name="keywords" content="程序化交易平台">
    <meta name="description" content="程序化交易平台|后台管理系统">
    @yield('meta')

    <link href="{{url('/src/admin/css/bootstrap.min.css')}}?v=3.4.0" rel="stylesheet">
    <link href="{{url('/src/admin/css/font-awesome.min.css')}}?v=4.3.0" rel="stylesheet">
    <link href="{{url('/src/admin/css/style.min.css?v=3.2.0')}}" rel="stylesheet">
    {{--    <link href="{{url('/src/admin/css/animate.min.css')}}" rel="stylesheet">--}}
    <link href="{{url('/src/admin/css/plugins/select2/select2.min.css')}}" rel="stylesheet">
    @yield('css')
    
    <link href="{{url('/src/admin/css/custom.css')}}" rel="stylesheet">
</head>
{{--<body class="fixed-sidebar full-height-layout gray-bg">--}}
<body class="fixed-sidebar full-height-layout gray-bg mini-navbar">
@yield('content')
<!-- 全局js -->
<script src="{{url('/src/admin/js/jquery.min.js')}}"></script>
<script src="{{url('/src/admin/js/jquery-ui-1.10.4.min.js')}}"></script>
<script src="{{url('/src/admin/js/bootstrap.min.js')}}?v=3.4.0"></script>
<script src="{{url('/src/admin/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
<script src="{{url('/src/admin/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{url('/src/admin/js/plugins/layer/layer.min.js')}}"></script>
<!-- 自定义js -->
<script src="{{url('/src/admin/js/hplus.min.js')}}?v=3.2.0"></script>
<script src="{{url('/src/admin/js/contabs.min.js')}}"  type="text/javascript" ></script>
<script src="{{url('/src/admin/js/plugins/select2/select2.min.js')}}"></script>
<script>
    // 顶部导航切换
    $('#top_nav_wrap').on('click','.index-hd-nav-item',function(){
        var idx=$(this).index();
        var target=$('#side-menu');
        $(this).addClass('active')
            .siblings().removeClass('active');
        target.children().removeClass('active').eq(idx).addClass('active');
    })
    // 全屏
    function viewInFullScreen(){
        var el = document.documentElement;
        var rfs = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el.msRequestFullscreen;      
            if(typeof rfs != "undefined" && rfs) {
                rfs.call(el);
            };
            return;
    }
</script>
<!-- 第三方插件 -->
{{--<script src="{{url('/src/admin/js/plugins/pace/pace.min.js')}}"></script>--}}
@yield('js')
</body>
</html>