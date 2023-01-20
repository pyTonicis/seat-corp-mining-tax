@extends('web::layouts.grids.8-4')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush

@section('left')
    <div class="card">
        <div class="card-header">
            <h3>Corporation Mining Thieves</h3>
        </div>
        <div class="card-body">
            <canvas id="myChart" height="150"></canvas>
        </div>
    </div>
@stop
@push('javascript')
    <script type="text/javascript">
        $(document).ready(function(){

        var datum =  '01-2022';
        var quantity = 132;
        const labels = Utils.months({count: 12});

        const data = {
            labels: labels,
            datasets: [
                {
                label: '',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: ['15000', '27000', '1000', '50000', '11943', '15000', '89322', '1111', '19191', '10001', '1000', '41001'] ,
                }
            ]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                title: {
                    display: true,
                    text: 'Mining volume last 12 month´s'
                }
            }
        };

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        )});
    </script>
@endpush