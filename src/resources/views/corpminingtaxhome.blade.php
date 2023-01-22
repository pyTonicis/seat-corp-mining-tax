@extends('web::layouts.grids.12')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush

@section('full')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mining volume last 12 month`s</h3>
                </div>
                <div class="card-body">
                    <canvas id="mining_chart" height="150px"></canvas>
                </div>
            </div>
        </div>
    </div>
@stop
@push('javascript')
    <script type="text/javascript">
        const labels = ["01-22", "02-22", "03-22", "04-22", "05-22", "06-22", "07-22"]
        const data = {
            labels: labels,
            datasets: [{
                label: 'Volume in m³',
                data: [65, 59, 80, 81, 56, 55, 40],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(255, 99, 132, 0.5)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)'
                ],
                borderWidth: 1
            }]
        };
        const config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        };

            new Chart(document.getElementById('mining_chart').getContext('2d'), config);
    </script>
@endpush