@extends('admin.master')
<title>用户中心</title>
@section('css')
    <link href="{{url('/src/bootstrap-table/src/bootstrap-table.css')}}?v=3.22" rel="stylesheet">
    <link href="{{url('/src/layui/css/layui.css')}}?v=3.4.0.1" rel="stylesheet">
@endsection
@section('content')
        <div class="wrapper wrapper-content  animated fadeInRight">
            <div class="row">
                <div class="col-sm-4">
                    <div class="ibox " style="margin-bottom:0;">
                        <div class="ibox-content">
                            <div style="text-align:center;">
                                <div class="m-b-sm" style="margin-top:20px;">
                                    <a class="layui-btn" id="test1" style="background-color:#ffffff;" title="请上传正方形头像" >
                                        @if(isset($headImage))
                                            <img id="demo1" alt="image" class="img-circle" src="{{$headImage}}" style="width:90px;height:90px;">
                                        @else
                                            <img id="demo1" alt="image" class="img-circle" src="{{url('image.png')}}" style="width:90px;height:90px;">
                                        @endif
                                    </a>
                                </div>
                                <br/>
                                <br/>
                                <br/>
                                <h2>{{$username}}</h2>
                                <br/>
                                <h3>{{$last_time}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="ibox">
                        <div class="ibox-content" style="padding:0;">
                            <div  style="display:inline-flex;width: 100%;">
                                <div class="tips" style="text-align:center;width:33.33333%;height:60px;line-height:60px;border:1px solid #efefef;">
                                    <h3 class="dataTip" style="">{{$loginCount}}</h3>
                                    <h3 class="dataTip" style="">登录</h3>
                                </div>
                                <div class="tips" style="text-align:center;width:33.33333%;height:60px;line-height:60px;border:1px solid #efefef;">
                                    <h3 class="dataTip" style="">{{$operateCount}}</h3>
                                    <h3 class="dataTip" style="">操作</h3>
                                </div>
                                <div class="tips" style="text-align:center;width:33.33333%;height:60px;line-height:60px;border:1px solid #efefef;">
                                    <h3 class="dataTip" style="">333</h3>
                                    <h3 class="dataTip" style="">消息</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="clients-list">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#tab-1" onClick="loginData()" ><i class="fa fa-file"></i> 登录日志</a>
                                    </li>
                                    <li class=""><a data-toggle="tab" href="#tab-2" onClick="operateData()"><i class="fa fa-file"></i> 操作日志</a>
                                    </li>
                                    <li class=""><a data-toggle="tab" href="#tab-3" onClick="personalDoing()" ><i class="fa fa-user"></i> 密码修改</a>
                                    </li>
                                    <li class=""><a data-toggle="tab" href="#tab-4" onClick="personalDoing()" ><i class="fa fa-user"></i>个性化</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div id="tab-1" class="tab-pane active">
                                        <div class="full-height-scroll">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover" id="loginTable"></table>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab-2" class="tab-pane">
                                        <div class="full-height-scroll">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover" id="operateTable"></table>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab-3" class="tab-pane">
                                        <div class="full-height-scroll">
                                            <div class="table-responsive">
                                                <form id="pwdForm" class="form-horizontal" style="margin-top:15px;">
                                                    <input type="hidden" value="{{session('admin.passwd')}}">
                                                    <div class="container" style="width:100%;">
                                                        <div class="row form-group">
                                                            <label class="control-label col-lg-2" for="pwd_old" style="text-align:left;">旧密码</label>
                                                            <div class="col-lg-5 col-md-6">
                                                                <input class="form-control" name="pwd_old" id="pwd_old" type="password">
                                                                <span class="tips1" style="display:none;color:red;">旧密码输入有误</span>
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <label class="control-label col-lg-2" for="pwd_new" style="text-align:left;">新密码</label>
                                                            <div class="col-lg-5 col-md-6">
                                                                <input class="form-control" name="pwd_new" id="pwd_new" type="password">
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <label class="control-label col-lg-2" for="pwd_re_new" style="text-align:left;">确认新密码</label>
                                                            <div class="col-lg-5 col-md-6">
                                                                <input class="form-control" name="pwd_re_new" id="pwd_re_new" type="password">
                                                                <span class="tips2" style="display:none;color:red;">两次新密码输入不一致</span>
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col-lg-3 col-md-3" style="margin-left:20%;">
                                                                <button class="btn btn-success" id="editBtn">确认修改</button>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3">
                                                                <button class="btn btn-default" id="resetBtn">重置</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab-4" class="tab-pane">
                                        <div id="legend" class="">
                                            <h3>请选择框架颜色</h3>
                                        </div>
                                        <div class="control-group" style="margin-left:80px;">
                                            <form id="framColor" class="form-horizontal" style="margin-top:15px;">
                                            <div class="controls">
                                                @if(!empty($colors))
                                                    @foreach($colors as $item)
                                                        <label class="radio inline" style="margin-right:43px;height:50px;line-height:50px;text-align:center;">
                                                            <input value="{{$item['id']}}"  name="color_id" type="radio" style="margin-top:4px;">
                                                            <div style="width:20px;height:20px;background-color:{{$item['color']}};margin-left:10px;"></div>
                                                        </label>
                                                    @endforeach
                                                    @endif
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-lg-3 col-md-3" style="">
                                                    <button class="btn btn-success" id="colorBtn">确定</button>
                                                </div>
                                            </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection


@section('js')
    <script src="{{url('/src/bootstrap-table/dist/bootstrap-table.js')}}" type="text/javascript"></script>
    <script src="{{url('/src/bootstrap-table/dist/bootstrap-table-locale-all.js')}}"></script>
    <script src="{{url('/src/easyui/js/DatePicker/WdatePicker.js')}}"></script>
    <script src="{{url('/src/layui/layui.js')}}"></script>
    <script type="text/javascript">
            var token = '{{csrf_token()}}';
            var jid = 10010;
            $(function(){
                loginData();
            });

            function loginData()
            {
                $('#loginTable').bootstrapTable('destroy').bootstrapTable({
                    url: '{{url("admin/operatelog/ajaxLoginData?_token=")}}'+token ,         //请求后台的URL（*）
                    method: 'get',                      //请求方式（*）
                    toolbar: '#toolbar',                //工具按钮用哪个容器
                    striped: true,                      //是否显示行间隔色
                    cache: true,                       //是否使用缓存，默认为true，所以一般情况下需要设置一下这个属性（*）
                    pagination: true,                   //是否显示分页（*）
                    sortable: true,                     //是否启用排序
                    sortOrder: "asc",                   //排序方式
                    queryParams: queryParams,//传递参数（*）
                    sidePagination: "server",           //分页方式：client客户端分页，server服务端分页（*）
                    pageNumber: 1,                       //初始化加载第一页，默认第一页
                    pageSize: 20,                       //每页的记录行数（*）
                    pageList: [10, 25, 50, 100],        //可供选择的每页的行数（*）
                    search: false,                       //是否显示表格搜索，此搜索是客户端搜索，不会进服务端，所以，个人感觉意义不大
                    strictSearch: false,                  //搜索表格
                    showColumns: false,                  //是否显示所有的列
                    showRefresh: false,                  //是否显示刷新按钮
                    minimumCountColumns: 1,             //最少允许的列数
                    clickToSelect: true,                //是否启用点击选中行
                    uniqueId: "id",                     //每一行的唯一标识，一般为主键列
                    showToggle: false,                    //是否显示详细视图和列表视图的切换按钮
                    cardView: false,                    //是否显示详细视图
                    detailView: false,                   //是否显示父子表
                    showFooter: false,                    //显示表格数据
                    smartDisplay: false,//智能显示分页按钮
                    classes: 'table table-bordered table-responsive table-hover', // Class样式
                    paginationPreText: '上一页',
                    paginationNextText: '下一页',
                    columns: [
                        {
                            field: 'username',
                            title: '操作人',
                            align: 'center'
                        },
                        {
                            field: 'create_at',
                            title: '操作时间',
                            align: 'center'
                        }
                    ]
                });
            }



            function operateData()
            {
                $('#operateTable').bootstrapTable('destroy').bootstrapTable({
                    url: '{{url("/admin/operatelog/ajaxOperateData?_token=")}}'+token ,         //请求后台的URL（*）
                    method: 'get',                      //请求方式（*）
                    toolbar: '#toolbar',                //工具按钮用哪个容器
                    striped: true,                      //是否显示行间隔色
                    cache: true,                       //是否使用缓存，默认为true，所以一般情况下需要设置一下这个属性（*）
                    pagination: true,                   //是否显示分页（*）
                    sortable: true,                     //是否启用排序
                    sortOrder: "asc",                   //排序方式
                    queryParams: queryParams,//传递参数（*）
                    sidePagination: "server",           //分页方式：client客户端分页，server服务端分页（*）
                    pageNumber: 1,                       //初始化加载第一页，默认第一页
                    pageSize: 20,                       //每页的记录行数（*）
                    pageList: [10, 25, 50, 100],        //可供选择的每页的行数（*）
                    search: false,                       //是否显示表格搜索，此搜索是客户端搜索，不会进服务端，所以，个人感觉意义不大
                    strictSearch: false,                  //搜索表格
                    minimumCountColumns: 1,             //最少允许的列数
                    uniqueId: "id",                     //每一行的唯一标识，一般为主键列
                    cardView: false,                    //是否显示详细视图
                    detailView: false,                   //是否显示父子表
                    showFooter: false,                    //显示表格数据
                    smartDisplay: false,//智能显示分页按钮
                    classes: 'table table-bordered table-responsive table-hover', // Class样式
                    paginationPreText: '上一页',
                    paginationNextText: '下一页',
                    columns: [
                        {
                            field: 'username',
                            title: '操作人',
                            align: 'center'
                        },
                        {
                            field: 'details',
                            title: '路径定义',
                            align: 'center'
                        },
                        {
                            field: 'path',
                            title: '操作路径',
                            align: 'center'
                        },
                        {
                            field: 'ip',
                            title: '操作ip',
                            align: 'center'
                        },
                        {
                            field: 'method',
                            title: '操作方法',
                            align: 'center'
                        },
                        {
                            field: 'create_at',
                            title: '操作时间',
                            align: 'center'
                        }
                    ]
                });
            }

            function queryParams(params, type) {
                return {
                    limit: params.limit, // 每页显示数量
                    offset: params.offset // SQL语句偏移量
                }
            }

            function personalDoing()
            {

            }

            layui.use('upload', function(){
                var $ = layui.jquery
                    ,upload = layui.upload;
                //普通图片上传
                upload.render({
                    elem: '#test1',
                    url: '{{"/admin/admin/uploadImg"}}',
                    exts: 'jpeg|jpg|png|gif',
                    size: 100,
                    before: function(obj){
                        //预读本地文件示例，不支持ie8
                        obj.preview(function(index, file, result){
                            $('#demo1').attr('src', result); //图片链接（base64）
                        });
                    },
                    done: function(res){
                       console.log(res)
                        if(res.success){

                        }
                    },
                    error: function(){
                        //演示失败状态，并实现重传
                        var demoText = $('#demoText');
                        demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                        demoText.find('.demo-reload').on('click', function(){
                            uploadInst.upload();
                        });
                    }
                });
            })

            $("#pwd_old").on('blur',function(){
                var data = $(this).val();
                var pwd = $("input[type='hidden']").val();
                if(data !== pwd){
                    $(".tips1").show();
                }
            })

            $("#pwd_old").on('focus',function(){
                $(".tips1").hide();

            })

            $("#pwd_re_new").on('blur',function(){
                var data = $(this).val();
                var pwd_new = $("#pwd_new").val();
                if(data !== pwd_new){
                    $(".tips2").show();
                }
            })

            $("#pwd_new").on('focus',function(){
                $(".tips2").hide();

            })

            $("#pwd_re_new").on('focus',function(){
                $(".tips2").hide();

            })

            $("#editBtn").on('click',function(){

                var pwd_new = $("#pwd_new").val();
                var pwd_re_new = $("#pwd_re_new").val();
                if(pwd_new !== pwd_re_new){
                    $(".tips2").show();
//                    $("#tab-1").removeClass('active');
//                    $("#tab-3").addClass('active');
                    $(".tab-content").children('div').eq(2).addClass('active');
//                    console.log(ss);
//                    return;
                    //选项卡固定在修改密码上
                }

                $.ajax({
                    url:'{{"/admin/admin/changePwd?_token="}}'+'{{csrf_token()}}',
                    data:{'pwd':pwd_new},
                    method:'post',
                    dataType:'json',
                    success:function(res){
                        if(res.success){
                            layer.msg('修改成功！',{icon:1,time:2000});
                        }else{
                            layer.msg('修改失败！',{icon:2,time:2000});
                        }
                    }
                })
            })

            $("#resetBtn").on('click',function(){
                var pwd_old = $("#pwd_old").val('');
                var pwd_new = $("#pwd_new").val('');
                var pwd_re_new = $("#pwd_re_new").val('');
            })

            $("#colorBtn").on('click',function(){
                var css = $("#framColor").serialize();
                $.ajax({
                    url:'{{"/admin/admin/changeFrameColor?_token="}}'+token+'&'+css,
                    dataType:'json',
                    success:function(response){
                        if(response.success){
                            layer.msg('修改成功',{'icon':1})
                        }
                    }
                })
            })






    </script>
@endsection