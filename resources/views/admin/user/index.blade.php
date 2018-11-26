@extends('admin.master')
@section('css')
    <link href="{{url('/src/bootstrap-table/dist/bootstrap-table.css')}}?v=3.22" rel="stylesheet">
    <link href="{{url('/src/bootstrap-table/dist/extensions/bootstrap3-editable/css/bootstrap-editable.css')}}?v=3.22" rel="stylesheet">
    <style>
        .select2-container--open{
            z-index:9999999
        }

        .modal-backdrop {
            filter: alpha(opacity=0)!important;
            opacity: 0!important;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading">微信用户列表</div>
                    <table id="tb_departments">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12" style="height: 0px;">
                                    <form id="formSearch" class="form-horizontal">
                                        <div class="form-group" style=" margin-top: 27px;">
                                            <div class="col-xs-1">
                                                <input type="text"
                                                       id="s_nickName"
                                                       name="nickName"
                                                       class="form-control"
                                                       placeholder="昵称">
                                            </div>
                                            <div class="col-xs-1">
                                                <input type="text"
                                                       id="s_mobile"
                                                       name="mobile"
                                                       class="form-control"
                                                       placeholder="电话号码">
                                            </div>
                                            <input type="hidden"
                                                   name="_token"
                                                   value="{{csrf_token()}}">

                                            <div class="col-sm-1">
                                                <button type="button" id="btn_query"
                                                        class="btn btn-primary btn-sm"
                                                        onclick="doSearch()"><i class="glyphicon glyphicon-search"></i>&nbsp;查询
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('js')
    <script src="{{url('/src/bootstrap-table/src/bootstrap-table.js')}}" type="text/javascript"></script>
    <script src="{{url('/src/bootstrap-table/dist/locale/bootstrap-table-zh-CN.js')}}"></script>
    <script src="{{url('/src/bootstrap-table/dist/extensions/bootstrap3-editable/js/bootstrap-editable.min.js')}}"></script>
    <script src="{{url('/src/bootstrap-table/dist/extensions/editable/bootstrap-table-editable.min.js')}}"></script>
    {{--<script src="{{url('/src/easyui/js/DatePicker/WdatePicker.js')}}"></script>--}}
    <script>

        $(function () {
            //1.初始化Table
            var oTable = new TableInit();
            oTable.Init();
            $("#myModal").draggable();

        });

        var token = '{{csrf_token()}}';

        var TableInit = function () {
            var oTableInit = new Object();
            //初始化Table
            oTableInit.Init = function () {
                $('#tb_departments').bootstrapTable({
                    url: '{{url("/admin/user/ajaxData")}}?_token='+token,         //请求后台的URL（*）
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
                    showColumns: true,                  //是否显示所有的列
                    showRefresh: true,                  //是否显示刷新按钮
                    minimumCountColumns: 1,             //最少允许的列数
                    clickToSelect: true,                //是否启用点击选中行
                    uniqueId: "id",                     //每一行的唯一标识，一般为主键列
                    showToggle: true,                    //是否显示详细视图和列表视图的切换按钮
                    cardView: false,                    //是否显示详细视图
                    detailView: false,                   //是否显示父子表
                    showFooter: false,                    //显示表格数据
                    smartDisplay: false,//智能显示分页按钮
                    classes: 'table table-bordered table-responsive table-hover', // Class样式
                    paginationPreText: '上一页',
                    paginationNextText: '下一页',
                    columns: [
                        {
                            field:'nickName',
                            title:'用户昵称',
                            align:'center'
                        },
                        {
                            field:'avatar',
                            title:'微信头像',
                            align:'center',
                        },
                        {
                            field:'mobile',
                            title:'联系电话',
                            align:'center',
                        },
                        {
                            field:'create_at',
                            title:'添加时间',
                            align:'center',
                        },
                        {
                            field:'beCalled',
                            title:'状态',
                            formatter:function(value,row,index){
                                if(row.beCalled == 1){
                                    if(row.status == 1){
                                        return '<a href="javascript:void(0);" onClick="beCalled('+ row.uid+')">待沟通</a>';
                                    }

                                }else if(row.beCalled == 2){
                                    return '<a >已沟通</a>';
                                }
                            }
                        },
                        @if(super_authority())
                        {
                            field: 'ff',
                            title: '操作',
                            width: 250,
                            formatter: function (value, row, index) {
                                var html = '';
                                if(row.status == 1){
                                     html += '<a href="javascript:void(0);" class="btn btn-danger btn-xs" onClick="changeStatus('+ row.uid+'\,'+ row.status+')"><i class="glyphicon glyphicon-edit"></i>&nbsp;加入黑名单</a>&nbsp;&nbsp;';
                                }else if(row.status == 2){
                                    html += '<a href="javascript:void(0);" class="btn btn-warning btn-xs" onClick="changeStatus('+ row.uid+'\,'+ row.status+')"><i class="glyphicon glyphicon-edit"></i>&nbsp;移出黑名单</a>'
                                }
                                return html;
                            },
                        }
                        @endif
                    ],
                });
            };
            return oTableInit;
        };

        // 分页查询参数，是以键值对的形式设置的
        function queryParams(params) {
            return {
                nickName:$("#s_nickName").val(),
                mobile:$('#s_mobile').val(),
                limit: params.limit, // 每页显示数量
                offset: params.offset // SQL语句偏移量
            }
        }

        function doSearch() {
            $('#tb_departments').bootstrapTable('refresh', {url: '{{url("/admin/user/ajaxData")}}?_token='+token});
        }


        function changeStatus(id,status)
        {
            if(status ===1){
                var $tips = '确定拉黑吗？';
            }else if(status ===2){
                var $tips = '确定从黑名单中移出吗？';
            }
            layer.confirm($tips, {
                btn: ['确定', '取消'] //按钮
            }, function () {
                $.ajax({
                    url: '{{url('/admin/user/changeStatus')}}?_token=' + token,
                    data: {'uid': id, 'status': status},
                    type: 'post',
                    dataType: 'json',
                    success: function (data) {
                        if (data.success) {
                            layer.msg('操作成功！', {icon: 1, time: 1000});
                            doSearch();
                        } else {
                            layer.msg('操作失败！', {icon: 2, time: 1000});
                        }
                    }
                });
            },function(){

            });
        }

        function beCalled(id){
            layer.confirm('确认加入已沟通吗？', {
                btn: ['确定', '取消'] //按钮
            }, function () {
                $.ajax({
                    url: '{{url('/admin/user/beCalled')}}?_token=' + token,
                    data: {'uid': id},
                    type: 'post',
                    dataType: 'json',
                    success: function (data) {
                        if (data.success) {
                            layer.msg('操作成功！', {icon: 1, time: 1000});
                            doSearch();
                        } else {
                            layer.msg('操作失败！', {icon: 2, time: 1000});
                        }
                    }
                });
            },function(){

            });
        }

    </script>
@endsection
