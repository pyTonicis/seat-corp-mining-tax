@extends('web::layouts.grids.12')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush

@section('full')
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mining volume last 12 month`s</h3>
                </div>
                <div class="card-body">
                    <canvas id="mining_chart" height="150px"></canvas>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Mining Types</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@push('javascript')
    <script type="text/javascript">

            const DATA_COUNT = 5;
            const NUMBER_CFG = {count: DATA_COUNT, min: 0, max: 100};

            const data = {
                labels: ['Red', 'Orange', 'Yellow', 'Green', 'Blue'],
                datasets: [
                    {
                        label: 'Dataset 1',
                        data: ['15', '200', '401', '44', '195'],
                        backgroundColor: 'rgb(255,99,132)',
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

            new Chart(document.getElementById('mining_chart').getContext('2d'), config);
    </script>
@endpush