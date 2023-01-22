@extends('web::layouts.grids.12')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush

@section('full')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <canvas id="mining_chart" height="300"></canvas>
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

            new Chart(document.getElementById('mining_chart').getContext('2d'), config)
        });
    </script>
@endpush