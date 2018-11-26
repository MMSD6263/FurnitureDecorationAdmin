@extends('admin.master')
@section('css')
    <link href="{{url('/src/bootstrap-table/dist/bootstrap-table.css')}}?v=3.22" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading">运营统计列表</div>
                    <table id="tb_departments">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12" style="height: 0px;">
                                    <form id="formSearch" class="form-horizontal">
                                        <div class="form-group" style=" margin-top: 27px;">
                                            <input type="hidden"
                                                   name="_token"
                                                   value="{{csrf_token()}}">
                                            <div class="col-xs-1">
                                                <input type="text" placeholder="开始日期(创)" style="height: 30px;"
                                                       onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})"
                                                       class=" form-control Wdate" id="start" value="">
                                            </div>
                                            <div class="col-xs-1">
                                                <input type="text" placeholder="结束日期(创)" value="" style="height: 30px;"
                                                       onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})"
                                                       class=" form-control Wdate" id="end">
                                            </div>
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
    <script src="{{url('/src/bootstrap-table/dist/bootstrap-table.js')}}" type="text/javascript"></script>
    <script src="{{url('/src/bootstrap-table/dist/locale/bootstrap-table-zh-CN.js')}}"></script>
    <script src="{{url('/src/easyui/js/DatePicker/WdatePicker.js')}}"></script>
    <script>
        $(function () {
            //1.初始化Table
            var oTable = new TableInit();
            oTable.Init();
        });
        var token = '{{csrf_token()}}';
        var url;
        function doSearch() {
            $('#tb_departments').bootstrapTable('refresh', {url: '{{url("/admin/operation/ajaxData")}}?_token='+token});
        }
        /*
         * 初始化获取扣量数据
         * */
        var TableInit = function () {
            var oTableInit = new Object();
            //初始化Table
            oTableInit.Init = function () {
                $('#tb_departments').bootstrapTable({
                    url: '{{url("/admin/operation/ajaxData?_token=")}}'+token,         //请求后台的URL（*）
                    method: 'get',                      //请求方式（*）
                    toolbar: '#toolbar',                //工具按钮用哪个容器
                    striped: true,                      //是否显示行间隔色
                    cache: true,                       //是否使用缓存，默认为true，所以一般情况下需要设置一下这个属性（*）
                    pagination: true,                   //是否显示分页（*）
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
                            field:'id',
                            title:'ID',
                            align:'center'
                        },
                        {
                            field:'new_user',
                            title:'新增用户',
                            align:'center',
                            sortable:true,
                        },
                        {
                            field:'active_user',
                            title:'活跃用户',
                            align:'center',
                            sortable:true,
                        },
                        {
                            field:'keep_user',
                            title:'留存用户',
                            align:'center',
                            sortable:true,
                        },
                        {
                            field:'call_user',
                            title:'沟通用户',
                            align:'center',
                            sortable:true,
                        },
                        {
                            field: 'time',
                            title: '统计时间',
                            align:'center'
                        },
                    ],
                    onLoadSuccess: function (data) {  //加载成功时执行
                        var sum_new_user = 0;
                        var sum_active_user = 0;
                        var sum_keep_user = 0;
                        var sum_call_user = 0;
                        for (var i in data.rows) {
                            sum_new_user     = parseInt(data.rows[i].sum_new_user);
                            sum_active_user  = parseInt(data.rows[i].sum_active_user);
                            sum_keep_user    = parseInt(data.rows[i].sum_keep_user);
                            sum_call_user    = parseInt(data.rows[i].sum_call_user);
                        }
                        var rows = [];
                        rows.push({
                            id: "合计",
                            new_user: parseInt(sum_new_user),
                            active_user: parseInt(sum_active_user),
                            keep_user: parseInt(sum_keep_user),
                            call_user: parseInt(sum_call_user),
                        });
                        $('#tb_departments').bootstrapTable('append', rows);
                    },
                    onLoadError: function () {  //加载失败时执行
                        layer.msg("加载数据失败", {time: 1500, icon: 2});
                    },
                });
            };
            return oTableInit;
        };
        // 分页查询参数，是以键值对的形式设置的
        function queryParams(params) {
            return {
                limit: params.limit, // 每页显示数量
                offset: params.offset, // SQL语句偏移量
                order: params.order,//排序
                sort: params.sort,//排序字段
                start: $("#start").val(),//排序字段
                end: $("#end").val(),//排序字段
            }
        }

    </script>
@endsection
