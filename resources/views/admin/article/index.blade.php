@extends('admin.master')
@section('css')
    <link href="{{url('/src/bootstrap-table/dist/bootstrap-table.css')}}?v=3.22" rel="stylesheet">
    <style>
        .select2-container--open{
            z-index:9999999
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading">文章列表</div>
                    <table id="tb_departments">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12" style="height: 0px;">
                                    <form id="formSearch" class="form-horizontal">
                                        <div class="form-group" style=" margin-top: 27px;">
                                            <div class="col-xs-2">
                                                <input type="text"
                                                       id="z_title"
                                                       name="title"
                                                       class="form-control"
                                                       placeholder="文章标题">
                                            </div>
                                            <input type="hidden"
                                                   name="_token"
                                                   value="{{csrf_token()}}">
                                            <div class="col-xs-1">
                                                <select id="z_status" style="height: 30px;">
                                                    <option value="">文章状态</option>
                                                    <option value="1">已审核</option>
                                                    <option value="0">待审核</option>
                                                    <option value="2">已下架</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-1">
                                                <select id="z_type" style="height: 30px;">
                                                    <option value="">文章类型</option>
                                                    @foreach($typeList as $itemt)
                                                        <option value="{{$itemt['artTypeId']}}">{{$itemt['artTypeName']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xs-1">
                                                <select id="z_source" style="height: 30px;">
                                                    <option value="">文章来源</option>
                                                    @foreach($sourceList as $items)
                                                        <option value="{{$items['sourceId']}}">{{$items['sourceName']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            {{--<div class="col-xs-1">--}}
                                                {{--<input type="text" placeholder="开始日期(创)" style="height: 30px;"--}}
                                                       {{--onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})"--}}
                                                       {{--class=" form-control Wdate" id="start" value="">--}}
                                            {{--</div>--}}
                                            {{--<div class="col-xs-1">--}}
                                                {{--<input type="text" placeholder="结束日期(创)" value="" style="height: 30px;"--}}
                                                       {{--onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})"--}}
                                                       {{--class=" form-control Wdate" id="end">--}}
                                            {{--</div>--}}
                                            <div class="col-xs-1">
                                                <button type="button" id="btn_query"
                                                        class="btn btn-primary btn-sm"
                                                        onclick="doSearch()"><i class="glyphicon glyphicon-search"></i>&nbsp;查询
                                                </button>
                                            </div>
                                            <div class="col-xs-1">
                                                <button type="button" id="btn_query"
                                                        class="btn btn-success btn-sm"
                                                        onclick="saveRedis()"><i class="glyphicon glyphicon-cog"></i>&nbsp;预热
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
//            $("#permission").select2();
            $("#myModal").draggable();
            $("#myModal_admin").draggable();
        });
        var token = '{{csrf_token()}}';
        var url;
        function doSearch() {
            $('#tb_departments').bootstrapTable('refresh', {url: '{{url("/admin/article/ajaxData")}}?_token='+token});
        }
        /*
        * 初始化获取扣量数据
        * */
        var TableInit = function () {
            var oTableInit = new Object();
            //初始化Table
            oTableInit.Init = function () {
                $('#tb_departments').bootstrapTable({
                    url: '{{url("/admin/article/ajaxData?_token=")}}'+token,         //请求后台的URL（*）
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
                            field:'checked',
                            checkbox:true,
                        },
                        {
                            field:'artID',
                            title:'文章id',
                            align:'center'
                        },
                        {
                            field:'artTypeName',
                            title:'文章栏目',
                            align:'center'
                        },
                        {
                            field:'artPic',
                            title:'文章图片',
                            align:'center',
                            formatter:function(value,row,index)
                            {
                                var html = '<a href="javascript:void(0);" onClick="editData('+ row.artID +')"><img src="'+row.artPic +'" style="width:45px;height:45px;"></a>';
                                return html;
                            }
                        },
                        {
                            field:'artTitle',
                            title:'文章标题',
                            align:'center',
                        },
                        {
                            field:'create_at',
                            title:'添加时间',
                            align:'center'
                        },
                        {
                            field: 'sourceName',
                            title: '文章来源',
                            align:'center'
                        },

                        {
                            field: 'status',
                            title: '文章状态',
                            align:'center',
                            formatter:function(value,row,index){
                                if(row.status == 1){
                                    return '<span style="color:#0D8B50">已审核</span>';
                                }else if(row.status == 0){
                                    return '<span style="color:#F42139">待审核</span>';
                                }else if(row.status == 2){
                                    return '<span style="color:#006FF2">已下架</span>';
                                }
                            }
                        },
                        @if(super_authority())
                            {
                                field: 'ff',
                                title: '操作',
                                width: 250,
                                formatter: function (value, row, index) {
                                    if(row.status == 1){
                                        var html= '<a href="javascript:void(0);" class="btn btn-success btn-xs" onClick="previewArticle('+row.artID+')" ><i class="glyphicon glyphicon-eye-open"></i>&nbsp;预览</a>&nbsp;&nbsp;' +
                                        '<a href="javascript:void(0);" class="btn btn-info btn-xs" onClick="changeStatus('+row.artID+','+row.status+')" ><i class="glyphicon glyphicon-remove"></i>&nbsp;下架</a>&nbsp;&nbsp;';
                                    }
//                                    else if(row.status == 0){
//                                        var html= '<a href="javascript:void(0);" class="btn btn-info btn-xs" onClick="changeStatus('+row.artID+','+row.status+')" ><i class="glyphicon glyphicon-check"></i>&nbsp;审核</a>&nbsp;&nbsp;'+
//                                        '<a href="javascript:void(0);" class="btn btn-danger btn-xs" onClick="delData('+row.artID+')" ><i class="glyphicon glyphicon-trash"></i>&nbsp;删除</a>&nbsp;&nbsp;'+
//                                        '<a href="javascript:void(0);" class="btn btn-success btn-xs" onClick="previewArticle('+row.artID+')"><i class="glyphicon glyphicon-eye-open"></i>&nbsp;预览</a>';
//                                    }
                                    return html;
                                }
                            }
                        @endif

                    ]
                });
            };
            return oTableInit;
        };
        // 分页查询参数，是以键值对的形式设置的
        function queryParams(params) {
            return {
                title:$('#z_title').val(),
                type:$('#z_type').val(),
                source:$('#z_source').val(),
                status:$('#z_status').val(),
                limit: params.limit, // 每页显示数量
                offset: params.offset // SQL语句偏移量
            }
        }

        function changeStatus(id,status)
        {
            layer.confirm('确定下架该文章吗？', {
                btn: ['确定', '取消'] //按钮
            }, function () {
                $.ajax({
                    url: '{{url('/admin/article/changeStatus')}}?_token=' + token,
                    data: {'id': id, 'status': status},
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

        function editData(id)
        {
             window.location.href = "{{url('/admin/article/editData')}}?_token="+token+'&id='+id+'&status=1';
        }

//        function delData(id){
//            layer.confirm('确认解除文章吗？', {
//                title:'提醒',
//                btn: ['确认','取消'] //按钮
//            }, function(index){
//                layer.close(index)
//                doDelete(id);
//            }, function(index){
//               layer.close(index);
//            });
//        }


        function previewArticle(id)
        {

            layer.open({
                type: 2,
                title: '很多时候，我们想最大化看，比如像这个页面。',
                shadeClose: true,
                shade: false,
                maxmin: true, //开启最大化最小化按钮
                area: ['375px', '667px'],
{{--                content: "{{url('admin/article/preview')}}?_token=" + token--}}
                content: "http://baidu.com"
            });
        }


        function saveRedis()
        {
            var arts = $("#tb_departments").bootstrapTable('getSelections');
            if(arts.length === 0){
                layer.msg('请至少选择一条需要预热的数据',{icon:5});
                return;
            }else{
                layer.confirm('确定预热选择的文章吗？', {
                    btn: ['确定', '取消'] //按钮
                }, function () {
                    var $artsArr = '';
                    $.each(arts,function(index,obj){
                        if($artsArr.length === 0){
                            $artsArr = obj.artID;
                        }else{
                            $artsArr += ','+ obj.artID;
                        }
                    })
                    $.ajax({
                        url: '{{url('/admin/article/saveRedis')}}?_token=' + token,
                        data: {'aids': $artsArr},
                        type: 'post',
                        dataType: 'json',
                        beforeSend:function(){
                            showloading(true);
                        },
                        success: function (data) {
                            showloading(false);
                            if (data.success) {
                                layer.msg('预热成功！', {icon: 1, time: 1000});
                                doSearch();
                            } else {
                                layer.msg('data.message！', {icon: 2, time: 1000});
                            }
                        }
                    });
                },function(){

                });
            }
        }


        function showloading(t) {
            if (t) {
                console.log(t);
                loading = layer.load(1, {
                    shade: [0.1, '#fff']
                });
            } else {
                layer.closeAll('loading');
            }
        }


    </script>
@endsection
