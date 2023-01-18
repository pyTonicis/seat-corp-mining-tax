@extends('web::layouts.grids.8-4')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush

@section('left')
                <div class="card">
                    <div class="card-header">
                        <h3>Mining last 12 Month's</h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <div class="chart has-fixed-height" id="bars_basic"></div>
                        </div>
                    </div>
                </div>
@stop
@push('javascript')
    <script type="text/javascript">
        var bars_basic_element = document.getElementById('bars_basic');
        if (bars_basic_element) {
            var bars_basic = echarts.init(bars_basic_element);
            bars_basic.setOption({
                color: ['#3398DB'],
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'shadow'
                    }
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                xAxis: [
                    {
                        type: 'category',
                        data: ['Fruit', 'Vegitable','Grains'],
                        axisTick: {
                            alignWithLabel: true
                        }
                    }
                ],
                yAxis: [
                    {
                        type: 'value'
                    }
                ],
                series: [
                    {
                        name: 'Total Products',
                        type: 'bar',
                        barWidth: '20%',
                        data: [
                            {{$a}},
                            {{$b}},
                            {{$c}}
                        ]
                    }
                ]
            });
        }
    </script>
@endpush