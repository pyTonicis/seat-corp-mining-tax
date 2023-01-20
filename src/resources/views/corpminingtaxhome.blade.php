@extends('web::layouts.grids.8-4')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush

@section('left')
    <div class="col-xs-12 col-sm-6">
    <div class="card">
        <div class="card-body">
            <div class="position-relative mb-4">
                <canvas id="x-chart" height="300" width="800"></canvas>
            </div>
        </div>
    </div>
    </div>
@stop
@push('javascript')
    <script type="text/javascript">
        $(document).ready(function(){

            const DATA_COUNT = 5;
            const NUMBER_CFG = {count: DATA_COUNT, min: 0, max: 100};

            const data = {
                labels: ['Red', 'Orange', 'Yellow', 'Green', 'Blue'],
                datasets: [
                    {
                        label: 'Dataset 1',
                        data: Utils.numbers(NUMBER_CFG),
                        backgroundColor: Object.values(Utils.CHART_COLORS),
                    }
                ]
            };
            const config = {
                type: 'pie',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Chart.js Pie Chart'
                        }
                    }
                },
            };

            new Chart(document.getElementById('x-chart'), config)
        });
    </script>
@endpush