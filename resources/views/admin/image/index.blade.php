@extends('admin.master')
@section('css')
    <link href="{{url('/src/bootstrap-table/dist/bootstrap-table.css')}}?v=3.22" rel="stylesheet">
    <link href="{{url('/src/admin/plugins/webuploader/diyUpload/css/webuploader.css')}}?v=3.4.0.1" rel="stylesheet">
    <link href="{{url('/src/admin/plugins/webuploader/diyUpload/css/diyUpload.css')}}?v=3.4.0.1" rel="stylesheet">
    <link href="{{url('/src/layui/css/layui.css')}}?v=3.4.0.1"  rel="stylesheet">
    <style>
        .layui-form-label{
            width:110px;
        }
        #demo {
            width: 100%;
            min-height: 150px;
            background: #C0EBEF;
            border: 3px #CCC dashed;
        }
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
                    <div class="panel-heading">图片列表</div>
                    <table id="tb_departments">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12" style="height: 0px;">
                                    <form id="formSearch" class="form-horizontal">
                                        <div class="form-group" style=" margin-top: 27px;">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <div class="col-xs-1">
                                                <select id="z_type" style="height: 30px;">
                                                    <option value="">图片类型</option>
                                                    <option value="1">单图</option>
                                                    <option value="2">套图</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-1">
                                                <select id="z_style" style="height: 30px;">
                                                    <option value="">风格</option>
                                                    @foreach($styleList as $items)
                                                        <option value="{{$items['id']}}">{{$items['style_name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xs-1">
                                                <select id="z_color" style="height: 30px;">
                                                    <option value="">色系</option>
                                                    @foreach($colorList as $itemc)
                                                        <option value="{{$itemc['id']}}">{{$itemc['color_name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xs-1">
                                                <select id="z_size" style="height: 30px;">
                                                    <option value="">户型</option>
                                                    @foreach($sizeList as $itemz)
                                                        <option value="{{$itemz['id']}}">{{$itemz['size_name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xs-1">
                                                <select id="z_room" style="height: 30px;">
                                                    <option value="">空间</option>
                                                    @foreach($roomList as $itemr)
                                                        <option value="{{$itemr['id']}}">{{$itemr['room_name']}}</option>
                                                    @endforeach
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
                                                        onclick="doAdd()"><i class="glyphicon glyphicon-plus"></i>&nbsp;添加图片
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

    <!--添加图片的modal开始-->
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
                        id="exampleModalLabel">图片编辑</h4>
                </div>
                <div class="modal-body">
                    <form id="video_form"
                          class="form-horizontal">
                        <input type="hidden" name="i_id" id="i_id" value="">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">风格</label>
                            <div class="col-sm-8">
                                <select class="form-control m-b"
                                        name="style[]"
                                        id="style"  style="width:468px;">
                                    <option value="">请选择风格</option>
                                    @if(!empty($styleList))
                                        @foreach($styleList as $item)
                                            <option value="{{$item['id']}}">{{$item['style_name']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">色系</label>
                            <div class="col-sm-8">
                                <select class="form-control m-b"
                                        name="color[]"
                                        id="color"  style="width:468px;">
                                    <option value="">请选择色系</option>
                                    @if(!empty($colorList))
                                        @foreach($colorList as $item_c)
                                            <option value="{{$item_c['id']}}">{{$item_c['color_name']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">户型</label>
                            <div class="col-sm-8">
                                <select class="form-control m-b"
                                        name="size[]"
                                        id="size"  style="width:468px;">
                                    <option value="">请选择户型</option>
                                    @if(!empty($sizeList))
                                        @foreach($sizeList as $item_s)
                                            <option value="{{$item_s['id']}}">{{$item_s['size_name']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">空间</label>
                            <div class="col-sm-8">
                                <select class="form-control m-b"
                                        name="room[]"
                                        id="room"  style="width:468px;">
                                    <option value="">请选择空间</option>
                                    @if(!empty($roomList))
                                        @foreach($roomList as $item_r)
                                            <option value="{{$item_r['id']}}">{{$item_r['room_name']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">类别</label>
                            <div class="col-sm-8">
                                <select class="form-control m-b"
                                        name="status"
                                        id="status">
                                    <option value="1">单图</option>
                                    <option value="2">套图</option>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">展示图片</label>
                            <input type="hidden" name="small_pic" id="small_pic" value="{{$small_pic or ''}}">
                            <div class="col-sm-8">
                                <div id="demo">
                                    <div id="as"></div>
                                    <div class="parentFileBox">
                                        <ul class="fileBoxUl">
                                            {{--@if(getType(json_decode($articleInfo['artPic'],true)) == 'array')--}}
                                                {{--@foreach(json_decode($articleInfo['artPic'],true) as $key=>$value)--}}
                                                    {{--<li class="diyUploadHover editingthumb">--}}
                                                        {{--<div class="viewThumb">--}}
                                                            {{--<img src="{{$value}}"></div>--}}
                                                        {{--<div class="diyCancel" id="Cancel{{$key}}"></div>--}}
                                                        {{--<div class="diySuccess"></div>--}}
                                                        {{--<div class="diyFileName" id="FileName{{$key}}">{{$value}}</div>--}}
                                                        {{--<div class="diyBar">--}}
                                                            {{--<div class="diyProgress"></div>--}}
                                                            {{--<div class="diyProgressText">0%</div>--}}
                                                        {{--</div>--}}
                                                    {{--</li>--}}
                                                {{--@endforeach--}}
                                            {{--@endif--}}
                                            {{--@endif--}}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-default"
                            data-dismiss="modal">取消
                    </button>
                    <button type="button"
                            class="btn btn-primary"
                            id="submitOn">确定
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--添加图片的modal结束-->

@endsection
@section('js')
    <script src="{{url('/src/bootstrap-table/dist/bootstrap-table.js')}}" type="text/javascript"></script>
    <script src="{{url('/src/bootstrap-table/dist/locale/bootstrap-table-zh-CN.js')}}"></script>
    <script src="{{url('/src/easyui/js/DatePicker/WdatePicker.js')}}"></script>
    <script src="{{url('/src/admin/plugins/webuploader/diyUpload/js/webuploader.html5only.min.js')}}"></script>
    <script src="{{url('/src/admin/plugins/webuploader/diyUpload/js/diyUpload.js')}}"></script>
    <script>
        $(function () {
            //1.初始化Table
            var oTable = new TableInit();
            oTable.Init();
//            $("#permission").select2();
            $("#myModal").draggable();
        });
        var token = '{{csrf_token()}}';
        var url;
        function doSearch() {
            $('#tb_departments').bootstrapTable('refresh', {url: '{{url("/admin/image/ajaxData")}}?_token='+token});
        }
        /*
        * 初始化获取扣量数据
        * */
        var TableInit = function () {
            var oTableInit = new Object();
            //初始化Table
            oTableInit.Init = function () {
                $('#tb_departments').bootstrapTable({
                    url: '{{url("/admin/image/ajaxData?_token=")}}'+token,         //请求后台的URL（*）
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
                            field:'type',
                            title:'类型',
                            formatter:function(value,row,index){
                                if(row.type == 1){
                                    return '<span>单图</span>';
                                }else if(row.type == 2){
                                    return '<span>套图</span>'
                                }
                            },
                            align:'center',
                        },
                        {
                            field:'small_pic',
                            title:'缩略图',
                            align:'center',
                            formatter:function(value,row,index)
                            {
                                return '<a  onClick="showPics('+ row.id +')"><img style="width:40px;height:40px;" src="'+ row.small_pic+ '"></a>';
                            }
                        },
                        {
                            field:'style_name',
                            title:'风格',
                            align:'center'
                        },
                        {
                            field:'color_name',
                            title:'色系',
                            align:'center'
                        },
                        {
                            field:'size_name',
                            title:'户型',
                            align:'center',
                        },
                        {
                            field:'room_name',
                            title:'空间',
                            align:'center',
                        },
                        {
                            field:'create_at',
                            title:'添加时间',
                            align:'center'
                        },
                        {
                            field:'acts',
                            title:'操作',
                            align:'left',
                            formatter:function(value,row,index){
                                return '<a href="javascript:void(0);" class="btn btn-info btn-xs" onClick="delData('+ row.id + ')" ><i class="glyphicon glyphicon-remove"></i>&nbsp;删除</a>';
                            }
                        }
                    ]
                });
            };
            return oTableInit;
        };
        // 分页查询参数，是以键值对的形式设置的
        function queryParams(params) {
            return {
                style:$('#z_style').val(),
                type:$('#z_type').val(),
                color:$('#z_color').val(),
                size:$('#z_size').val(),
                room:$('#z_room').val(),
                limit: params.limit, // 每页显示数量
                offset: params.offset // SQL语句偏移量
            }
        }

        function doAdd()
        {
            window.location.href = '{{url("/admin/image/add")}}'
//            $("#myModal").modal('show');
        }

        var pic_path = '';
        $('#as').diyUpload({
            url: "{{url('/admin/image/uploadImage')}}?_token={{csrf_token()}}",
            dataType:'json',
            success: function (data) {
                if (data.success) {
                    var small = $('#small_pic');
                    pic_path =small.val();
                    if(pic_path){
                        pic_path += data.message;
                    }else{
                        pic_path += data.message + "##";
                    }
                    small.val(pic_path);
                } else {
                    layer.msg('图片上传失败', {icon: 2});
                }
            },
            error: function (err) {
                console.info(err);
            },
            buttonText: '上传图片',
            chunked: false,
            // 分片大小
            chunkSize: 512 * 1024 * 100,
            //最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
            fileNumLimit: 6,
            fileSizeLimit: 500000 * 1024,
            fileSingleSizeLimit: 50000 * 1024,
            accept: {}
        });

        $('.editingthumb').on('click', '.diyCancel', function () {
            $(this).parents('.editingthumb').remove();
            var small = $("#small_pic");
            var small_pic = small.val();
            //定义一数组
            var small_arr = [];
            //字符分割
            small_arr = small_pic.split("##");
            console.log(small_arr);
            //获取当前操作的字符串
            var current_pic = $(this).siblings('.diyFileName').html();
            console.log(current_pic);
            removeByValue(small_arr, current_pic);

            var small_str = small_arr.join('##');
            small.val(small_str);
        })

        function removeByValue(arr, val) {
            for (var i = 0; i < arr.length; i++) {
                if (arr[i] == val) {
                    arr.splice(i, 1);
                    break;
                }
            }
        }

        function showPics(id)
        {
            $.ajax({
                url:'{{url("/admin/image/dataInfo")}}?_token='+token+'&id='+id,
                dataType:'json',
                success:function(json){
                    console.log(json)
                    layer.photos({
                        photos:json,
                        anim:3,
                    })

                }
            })
        }
        function delData(id)
        {
            layer.confirm('确定删除该图片吗',{
                btn:['确定','取消'],
                title:'提示',
                },function(){
                  $.ajax({
                      url:'{{url("/admin/image/deleteData")}}?_token='+token+'&id='+id,
                      dataType:'json',
                      success:function(response){
                          console.log(response)
                          if(response.success){
                              layer.msg(response.message,{icon:1});
                              doSearch();
                          }else{
                              layer.msg(response.message,{icon:2})
                          }
                      }
                  })
                },function(){

                }
            )
        }


    </script>
@endsection
