@extends('admin.master')
@section('css')
    {{--@include('vendor.ueditor.assets')--}}
    <link href="{{url('/src/admin/plugins/webuploader/diyUpload/css/webuploader.css')}}?v=3.4.0.1"
          rel="stylesheet">
    <link href="{{url('/src/admin/plugins/webuploader/diyUpload/css/diyUpload.css')}}?v=3.4.0.1"
          rel="stylesheet">
    <link href="{{url('/src/layui/css/layui.css')}}?v=3.4.0.1"  rel="stylesheet">
    <style>
        .layui-form-label{
            width:110px;
        }
        #demo {
            width:100%;
            min-height:150px;
            background:#C0EBEF;
            border: 3px #CCC dashed;
        }
    </style>
@endsection
@section('content')
    <blockquote class="layui-elem-quote layui-text">图片添加</blockquote>
    <form class="layui-form" style="width:50%;">
        <input type="hidden" name="id" id="pid" value="">
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">风格</label>
                <div class="layui-input-inline">
                    {{--@if($articleInfo['artTypeId'])--}}
                        <select name="style" id="style">
                            @foreach($styleList as $items)
                                <option value="{{$items['id']}}">{{$items['style_name']}}</option>
                                {{--@if($articleInfo['artTypeId'] == $itemt['artTypeId'])--}}
                                    {{--<option value="{{$itemt['artTypeId']}}" selected>{{$itemt['artTypeName']}}</option>--}}
                                {{--@else--}}
                                    {{--<option value="{{$itemt['artTypeId']}}">{{$itemt['artTypeName']}}</option>--}}
                                {{--@endif--}}
                            @endforeach
                        </select>
                    {{--@else--}}
                        {{--<select name="column" id="column">--}}
                            {{--<option value="">-请选择-</option>--}}
                            {{--@foreach($typeList as $itemt)--}}
                                {{--<option value="{{$itemt['artTypeId']}}">{{$itemt['artTypeName']}}</option>--}}
                            {{--@endforeach--}}
                        {{--</select>--}}
                    {{--@endif--}}

                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">色系</label>
                <div class="layui-input-inline">
                    <select name="color" id="color">
                        @foreach($colorList as $itemc)
                            {{--@if($articleInfo['sourceId'] == $items['sourceId'])--}}
                                {{--<option value="{{$items['sourceId']}}" selected>{{$items['sourceName']}}</option>--}}
                            {{--@else--}}
                                <option value="{{$itemc['id']}}">{{$itemc['color_name']}}</option>
                            {{--@endif--}}
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">户型</label>
                <div class="layui-input-inline">
                    {{--@if($articleInfo['artTypeId'])--}}
                    <select name="size" id="size">
                        @foreach($sizeList as $itemz)
                            <option value="{{$itemz['id']}}">{{$itemz['size_name']}}</option>
                            {{--@if($articleInfo['artTypeId'] == $itemt['artTypeId'])--}}
                            {{--<option value="{{$itemt['artTypeId']}}" selected>{{$itemt['artTypeName']}}</option>--}}
                            {{--@else--}}
                            {{--<option value="{{$itemt['artTypeId']}}">{{$itemt['artTypeName']}}</option>--}}
                            {{--@endif--}}
                        @endforeach
                    </select>
                    {{--@else--}}
                    {{--<select name="column" id="column">--}}
                    {{--<option value="">-请选择-</option>--}}
                    {{--@foreach($typeList as $itemt)--}}
                    {{--<option value="{{$itemt['artTypeId']}}">{{$itemt['artTypeName']}}</option>--}}
                    {{--@endforeach--}}
                    {{--</select>--}}
                    {{--@endif--}}

                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">空间</label>
                <div class="layui-input-inline">
                    <select name="room" id="room">
                        @foreach($roomList as $itemr)
                            {{--@if($articleInfo['sourceId'] == $items['sourceId'])--}}
                            {{--<option value="{{$items['sourceId']}}" selected>{{$items['sourceName']}}</option>--}}
                            {{--@else--}}
                            <option value="{{$itemr['id']}}">{{$itemr['room_name']}}</option>
                            {{--@endif--}}
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">类型</label>
            <div class="layui-input-block">
                <input type="radio" name="type"  value="1" title="单图"
                       {{--@if($articleInfo['audiences'] == 1)--}}
                       {{--checked @endif--}}
                >
                <input type="radio" name="type" value="2" title="套图"
                       {{--@if($articleInfo['audiences'] == 2)--}}
                       {{--checked @endif--}}
                >
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">文章封面</label>
            <input type="hidden" name="small_pic" id="small_pic" value="{{$small_pic or ''}}">
            <div class="col-sm-8" style="padding-left:0px;padding-right:0px;">
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
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn"  id="testss">保存编辑</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{url('/src/layui/layui.js')}}"></script>
    <script src="{{url('/src/admin/plugins/webuploader/diyUpload/js/webuploader.html5only.min.js')}}"></script>
    <script src="{{url('/src/admin/plugins/webuploader/diyUpload/js/diyUpload.js')}}"></script>
    <script type="text/javascript">

        //图片添加
        var token = '{{csrf_token()}}';
        layui.use(['form', 'layedit'], function(){
            var form = layui.form
                ,layer = layui.layer
                ,layedit = layui.layedit;

            var formData = {};

            $("#testss").on('click',function(){
                var pic = $('#small_pic').val();
                if(!pic){
                    layer.msg('请先添加好图片',{icon:5})
                    return;
                }
                formData = {
                    id:$("#pid").val(),
                    style:$('#style').val(),
                    color:$('#color').val(),
                    size:$('#size').val(),
                    room:$('#room').val(),
                    picUrl:pic,
                    type:$('input[name="type"]:checked').val(),
                    style_name:$('#style :selected').text(),
                    color_name:$('#color :selected').text(),
                    size_name:$('#size :selected').text(),
                    room_name:$('#room :selected').text(),
                };
//                var style_name = $('#style :selected').text();
//                console.log(style_name);
//                return;
                $.ajax({
                    'url':'{{"/admin/image/saveData"}}?_token='+token,
                    'method':'post',
                    'data':formData,
                    'dataType':'json',
                    success:function(res){
                        if(res.success){
                            layer.msg(res.message,{icon:1});
                            window.location.href = '{{url("/admin/image/index")}}'
                        }else{
                            layer.msg(res.message,{icon:5})
                            return false;
                        }
                    }
                })
            })
        });


        //图片上传
        var pic_path = '';
        $('#as').diyUpload({
            url: "{{url('/admin/image/uploadImage')}}?_token={{csrf_token()}}",
            dataType:'json',
            success: function (data) {
                if (data.success) {
                    var small = $('#small_pic');
                    pic_path = small.val();
                    pic_path += data.message + "##";
//                    if(pic_path){
//                        pic_path += '##'+data.message;
//                    }else{
//                        pic_path += data.message + "##";
//                    }
                    small.val(pic_path);
                    layer.msg('图片上传成功', {icon: 1});
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
    </script>
@endsection
