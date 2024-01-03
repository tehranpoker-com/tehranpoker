@extends('dashboard.layouts.master')
@section('content')
@action('admin_dashboard_before_counter')
<div class="row">
    @action('admin_dashboard_counter')
    @foreach ($dashboard_counter as $item)
    <div class="col-md-3">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">{!!$item['title']!!}</p>
                        <h4 class="mb-0">{{$item['count']}}</h4>
                    </div>
                    <div class="flex-shrink-0 align-self-center">
                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                            <span class="avatar-title"><i class="{{$item['icon']}} font-size-24"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@action('admin_dashboard_after_counter')
<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">{{admin_lang('browser_visits')}}</h4>
                <div id="doughnut-chart" class="e-charts"></div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">{{admin_lang('devices_visits')}}</h4>
                <div id="pie-chart" class="e-charts"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-sm-flex flex-wrap"><h4 class="card-title mb-4">{{admin_lang('visits')}}</h4></div>
                <div id="stacked-column-chart" class="apex-charts" dir="ltr"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script_code')
<script type="text/javascript" src="{{ asset('dashboard/js/apexcharts.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/js/echarts.min.js') }}"></script>
<script>
var DoughnutOption = {
    tooltip: {
        trigger: "item",
        formatter: "{a} <br/>{b}: {c} ({d}%)"
    },
    legend: {
        orient: "vertical",
        left: "left",
        data: ["Chrome", "Firefox", "Opera", "Safari", "IE", "Edge"],
        textStyle: {color: "#8791af"}
    },
    color: ["#f46a6a", "#34c38f", "#50a5f1", "#f1b44c", "#556ee6", "#2A3042"],
    series: [{
        name: "{{admin_lang('browser_visits')}}",
        type: "pie",
        radius: "50%",
        center: ["50%", "60%"],
        avoidLabelOverlap: !1,
        label: {normal: {show: !1,position: "center"},emphasis: {show: !0,textStyle: {fontSize: "20",fontWeight: "bold"}}},
        labelLine: {normal: {show: !1}},
        data: [
            {value: '{{$visitor_ischrome}}',name: "Chrome"}, 
            {value: '{{$visitor_isfirefox}}',name: "Firefox"}, 
            {value: '{{$visitor_isopera}}',name: "Opera"}, 
            {value: '{{$visitor_issafari}}',name: "Safari"}, 
            {value: '{{$visitor_isie}}',name: "IE"}, 
            {value: '{{$visitor_isedge}}',name: "Edge"}
        ],
        itemStyle: {
            emphasis: {
                shadowBlur: 10,
                shadowOffsetX: 0,
                shadowColor: "rgba(0, 0, 0, 0.5)"
            }
        }
    }]
}
DoughnutChart = echarts.init(document.getElementById("doughnut-chart"));
DoughnutChart.setOption(DoughnutOption, !0);

var PieOption = {
    tooltip: {
        trigger: "item",
        formatter: "{a} <br/>{b}: {c} ({d}%)"
    },
    legend: {orient: "vertical",
        x: "left",
        data: ["{{admin_lang('desktop')}}", "{{admin_lang('tablet')}}", "{{admin_lang('mobile')}}", "{{admin_lang('bot')}}"],
        textStyle: {color: "#8791af"}
    },
    color: ["#556ee6", "#f1b44c", "#f46a6a", "#50a5f1"],
    series: [{
        name: "{{admin_lang('devices_visits')}}",
        type: "pie",
        radius: ["50%", "70%"],
        avoidLabelOverlap: !1,
        label: {normal: {show: !1,position: "center"},emphasis: {show: !0,textStyle: {fontSize: "20",fontWeight: "bold"}}},
        labelLine: {normal: {show: !1}},
        data: [
            {value: '{{$visitor_isdesktop}}',name: "Desktop"}, 
            {value: '{{$visitor_istablet}}',name: "Tablet"}, 
            {value: '{{$visitor_ismobile}}',name: "Mobile"}, 
            {value: '{{$visitor_isbot}}',name: "Bot"}
        ]
    }]
}
PieChart = echarts.init(document.getElementById("pie-chart"));
PieChart.setOption(PieOption, !0);
var options_visitors = {
    chart: {height: 270,type: "bar",stacked: !0,toolbar: {show: !1},zoom: {enabled: !0}},
    plotOptions: {bar: {horizontal: !1,columnWidth: "15%",endingShape: "rounded"}},
    dataLabels: {enabled: !1},
    series: [{name: "",data: [@foreach($visitors as $item) "{{$item['total']}}", @endforeach]}],
    xaxis: {categories: [@foreach($visitors as $item) "{{$item['day']}}", @endforeach]},
    colors: ["#556ee6"],
    legend: {position: "bottom"},
    fill: {opacity: 1}
};
chart_visitors = new ApexCharts(document.querySelector("#stacked-column-chart"), options_visitors);
chart_visitors.render();
</script>
@endsection
