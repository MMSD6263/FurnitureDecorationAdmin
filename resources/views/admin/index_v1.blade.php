@extends('admin.master') @section('content')
    <div>
        <div class="row"></div>
        <div class="row">
            <div class="col-sm-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-success pull-right">新增</span>
                        <h5>新增用户</h5>
                    </div>
                    <div class="ibox-content">
                        <a href="#"><h1 class="no-margins">{{$count['new_user']}}</h1></a>
                        <div class="stat-percent font-bold text-success">98%
                            <i class="fa fa-bolt"></i>
                        </div>
                        <small>当天新增用户数量</small>
                        <span class="label label-success pull-right">次</span>
                        <h5>站内展示</h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-info pull-right">活跃</span>
                        <h5>活跃用户</h5>
                    </div>
                    <div class="ibox-content">
                        <a href="#"><h1 class="no-margins">{{$count['active_user']}}</h1></a>
                        <div class="stat-percent font-bold text-info">20%
                            <i class="fa fa-level-up"></i>
                        </div>
                        <small>当天活跃用户数量</small>
                        <span class="label label-info pull-right">次</span>
                        <h5>站内点击</h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-primary pull-right">留存</span>
                        <h5>留存用户</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{$count['keep_user']}}</h1>
                        <div class="stat-percent font-bold text-navy">44%
                            <i class="fa fa-level-up"></i>
                        </div>
                        <small>留存用户数量</small>
                        <span class="label label-primary pull-right">次</span>
                        <h5>站内分享</h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-primary pull-right">联络</span>
                        <h5>联络用户</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{$count['call_user']}}</h1>
                        <div class="stat-percent font-bold text-danger">38%
                            <i class="fa fa-level-down"></i>
                        </div>
                        <small>当天联络用户数量</small>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div>
                            {{--<h3 class="font-bold no-margins">--}}
                            {{--每日阅读量变化趋势图--}}
                            {{--</h3>--}}
                        </div>
                        <div>
                            <div class="row">
                                <div>
                                    <div id="readCount"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@section('js')
    <script src="{{url('/src/highchart/highcharts.js')}}"></script>
    <script src="{{url('/src/highchart/modules/exporting.js')}}"></script>
    <script src="{{url('/src/highchart/modules/oldie.js')}}"></script>

    <script>
        var data = {!! $data !!}
        var datas = eval(data);
        console.log(datas)

        var chart = Highcharts.chart('readCount', {
            chart: {
                type: 'spline'
            },
            title: {
                text: '用户运营总数据'
            },
            xAxis: {
                categories: datas.datetimeArr
            },
            yAxis: {
                title: {
                    text: '人数'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        // 开启数据标签
                        enabled: false
                    },
                    // 关闭鼠标跟踪，对应的提示框、点击事件会失效
                    enableMouseTracking: false
                }
            },
            series: [
                {
                    name: '活跃用户',
                    data: datas.active_user
                },
                {
                    name: '联络用户',
                    data: datas.call_user
                },
                {
                    name: '留存用户',
                    data: datas.keep_user
                },
                {
                    name: '新增用户',
                    data: datas.new_user
                }
            ]
        });
</script>


<script src="{{asset('src/easyui/echarsjs/esl.js')}}"></script>
<script src="{{url('/src/easyui/js/DatePicker/WdatePicker.js')}}"></script>
<script src="{{url('/src/bootstrap-table/src/bootstrap-table.js')}}" type="text/javascript"></script>
<script src="{{url('/src/bootstrap-table/src/locale/bootstrap-table-zh-CN.js')}}"></script>
<script>
</script>
@endsection