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
                    <div class="panel-heading">装修报价套餐列表</div>
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
                                                <select id="s_size" style="height:30px;width:90px;">
                                                    <option value="">户型</option>
                                                    <option value="1">一居室</option>
                                                    <option value="2">二居室</option>
                                                    <option value="3">三居室</option>
                                                    <option value="4">四居室</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-1">
                                                <button type="button" id="btn_query"
                                                        class="btn btn-primary btn-sm"
                                                        onclick="doSearch()"><i class="glyphicon glyphicon-search"></i>&nbsp;查询数据
                                                </button>
                                            </div>
                                            <div class="col-xs-1">
                                                <button type="button" id="btn_query"
                                                        class="btn btn-success btn-sm"
                                                        onclick="doAdd()"><i class="glyphicon glyphicon-plus"></i>&nbsp;添加套餐
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

    <!--添加修改套餐的modal-->
    <div class="modal fade"
         id="myModal"
         role="dialog"
         aria-labelledby="exampleModalLabel">
        <div class="modal-dialog"
             role="document">
            <div class="modal-content"
                 style="width:130%;">
                <div class="modal-header">
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"
                        id="exampleModalLabel"></h4>
                </div>
                <div class="modal-body">
                    <form id="video_form"
                          class="form-horizontal">
                        <input type="hidden" name="id" id="price_id" value="">
                        <input type="hidden" name="_token"  value="{{csrf_token()}}">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">户型</label>
                            <div class="col-sm-8">
                                <select class="form-control m-b" name="size" id="size" style="width:468px;">
                                    <option value="">请选择</option>
                                    <option value="1">一居室(60㎡以下)</option>
                                    <option value="2">二居室(60㎡-80㎡)</option>
                                    <option value="3">三居室(80㎡-100㎡)</option>
                                    <option value="4">四居室(100㎡以上)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">人工费</label>
                            <div class="col-sm-8">
                                <input class="form-control m-b" name="fee_human" id="fee_human"  style="width:468px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">材料费</label>
                            <div class="col-sm-8">
                                <input class="form-control m-b" name="fee_material" id="fee_material"  style="width:468px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">设计费</label>
                            <div class="col-sm-8">
                                <input class="form-control m-b" name="fee_design" id="fee_design"  style="width:468px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">监理费</label>
                            <div class="col-sm-8">
                                <input class="form-control m-b" name="fee_check" id="fee_check"  style="width:468px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">杂项费</label>
                            <div class="col-sm-8">
                                <input class="form-control m-b" name="fee_others" id="fee_others"  style="width:468px;">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-primary"
                            id="submitOn">确定
                    </button>
                    <button type="button"
                            class="btn btn-default"
                            data-dismiss="modal">取消
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--添加修改套餐的modal-->

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
            $("#myModal").draggable();
        });
        var token = '{{csrf_token()}}';
        var url;
        function doSearch() {
            $('#tb_departments').bootstrapTable('refresh', {url: '{{url("/admin/price/ajaxData")}}?_token='+token});
        }
        /*
        * 初始化获取扣量数据
        * */
        var TableInit = function () {
            var oTableInit = new Object();
            //初始化Table
            oTableInit.Init = function () {
                $('#tb_departments').bootstrapTable({
                    url: '{{url("/admin/price/ajaxData?_token=")}}'+token,         //请求后台的URL（*）
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
                            field:'size',
                            title:'户型大小',
                            align:'center',
                            formatter:function(value,row,index)
                            {
                                if(value == 1)
                                {
                                    return '<span>一居室(60㎡以下)</span>';
                                }else if(value == 2)
                                {
                                    return '<span>二居室(60㎡-80㎡)</span>';
                                }else if(value == 3)
                                {
                                    return '<span>三居室(80㎡-100㎡)</span>';
                                }else if(value == 4)
                                {
                                    return '<span>四居室(100㎡以上)</span>';
                                }
                            }
                        },
                        {
                            field:'fee_human',
                            title:'人工费',
                            align:'center'
                        },
                        {
                            field:'fee_material',
                            title:'材料费',
                            align:'center',
                        },
                        {
                            field:'fee_design',
                            title:'设计费',
                            align:'center'
                        },
                        {
                            field: 'fee_check',
                            title: '监理费',
                            align:'center'
                        },
                        {
                            field: 'fee_others',
                            title: '杂项费',
                            align:'center'
                        },
                        {
                            field: 'fee_check',
                            title: '监理费',
                            align:'center'
                        },
                        @if(super_authority())
                        {
                            field: 'ff',
                            title: '操作',
                            width: 250,
                            formatter: function (value, row, index) {
                                var rows = encodeURI(JSON.stringify(row));
                                var html = '<a href="javascript:void(0);" class="btn btn-success btn-xs" onClick="editData(\''+rows+'\')" ><i class="glyphicon glyphicon-edit"></i>&nbsp;修改</a>&nbsp;&nbsp;' +
                                           '<a href="javascript:void(0);" class="btn btn-info btn-xs" onClick="deleteData('+row.id+')" ><i class="glyphicon glyphicon-remove"></i>&nbsp;删除</a>&nbsp;&nbsp;';
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
                size:$('#s_size').val(),
                limit: params.limit, // 每页显示数量
                offset: params.offset // SQL语句偏移量
            }
        }

        function editData(rows)
        {
            var data = JSON.parse(decodeURI(rows));
            $("#myModal").modal('show');
            $("#exampleModalLabel").html('套餐修改');
            loadData(data);
        }

        function doAdd()
        {
            $("#myModal").modal('show');
            $("#exampleModalLabel").html('套餐添加');
            loadData();

        }

        function deleteData(id)
        {
            layer.confirm('确认解除该条数据吗？', {
                title:'提醒',
                btn: ['确认','取消'] //按钮
            }, function(index){
                layer.close(index)
                doDelete(id);
            }, function(index){
               layer.close(index);
            });
        }

        function doDelete(id)
        {
            $.ajax({
                url:'{{url("/admin/price/deleteData")}}?_token='+token+'&id='+id,
                dataType:'json',
                success:function(res){
                    if(res.success){
                        layer.msg(res.message,{icon:1,time:1000});
                        doSearch();
                    }else{
                        layer.msg(res.message,{icon:2,time:1000});
                    }
                }
            })
        }

        function loadData(data)
        {
            if(data){
                $("#price_id").val(data.id);
                $("#size").val(data.size);
                $("#fee_human").val(data.fee_human);
                $("#fee_material").val(data.fee_material);
                $("#fee_design").val(data.fee_design);
                $("#fee_check").val(data.fee_check);
                $("#fee_others").val(data.fee_others);
            } else {
                $("#price_id").val('');
                $("#size").val('');
                $("#fee_human").val('');
                $("#fee_material").val('');
                $("#fee_design").val('');
                $("#fee_check").val('');
                $("#fee_others").val('');
            }
        }

        $("#submitOn").on('click',function(){
            var data = $("#video_form").serialize();
            var fee_h = $("#fee_human").val();
            var fee_m = $("#fee_material").val();
            if(fee_h == ''){
                layer.msg('人工费必填',{icon:2,time:1000});
                return;
            }else if(fee_m == ''){
                layer.msg('材料费必填',{icon:2,time:1000});
                return;
            }
            $.ajax({
                url:'{{url("/admin/price/saveData")}}?'+ data,
                dataType:'json',
                success:function(res){
                    if(res.success){
                        layer.msg(res.message,{icon:1,time:1000});
                        $("#myModal").modal('hide');
                        doSearch();
                    }else{
                        layer.msg(res.message,{icon:2,time:1000});
                    }
                }
            })

        })

    </script>
@endsection
