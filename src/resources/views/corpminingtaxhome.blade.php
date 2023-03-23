@extends('web::layouts.grids.12')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush

@section('full')
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-yellow elevation-1"><i class="fa fa-dice-d20"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Mined Quantity <small>(last 12 month's)</small></span>
                    <span class="info-box-number">
                        {{ number_format($total_mined_quantity) }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-red elevation-1"><i class="fa fa-gem"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Mined Volume <small>(last 12 month's)</small></span>
                    <span class="info-box-number">
                        {{ number_format($total_mined_volume) }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-green elevation-1"><i class="fa fa-coins"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Mined ISK <small>(last 12 month's)</small></span>
                    <span class="info-box-number">
                        {{ number_format($total_mined_isk) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mining performance last 12 month`s</h3>
                </div>
                <div class="card-body">
                    <div style="height: 300px">
                    <canvas id="mining_chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mining volume per Group</h3>
                </div>
                <div class="card-body">
                    <div style="height: 300px">
                        <p id="tester">Hier könnte Ihre Werbung stehen!</p>
                        <p id="tester2">Huhu!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mining Log</h3>
                </div>
                <div class="card-body">
                    <table id="mining-log" class="table datatable compact table-condensed table-hover table-striped">
                        <thead>
                        <th class="text-center">Date</th>
                        <th class="text-center">System</th>
                        <th class="text-center">ORE</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">>Volume</th>
                        <th class="text-center">Est. Value</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">22-01-2023</td>
                                <td class="text-center">OPU2-R</td>
                                <td class="text-center">Lavish Vandanite</td>
                                <td class="text-center">61.000</td>
                                <td class="text-center">6.100.000</td>
                                <td class="text-center">2.351.108.000</td>
                            </tr>
                            <tr>
                                <td class="text-center">18-01-2023</td>
                                <td class="text-center">OPU2-R</td>
                                <td class="text-center">Vandanite</td>
                                <td class="text-center">11.000</td>
                                <td class="text-center">1.100.000</td>
                                <td class="text-center">179.230.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
@push('javascript')
    <script type="text/javascript">

        var chart_labels = @json($labels);
        var chart_data = @json($data);

        document.getElementById('tester').innerText = chart_labels;
        document.getElementById('tester2').innerText = chart_data;

        const data = {
            labels: chart_labels,
            datasets: [{
                label: 'Volume in x1000 m³',
                data: chart_data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.9)',
                    ],
                borderColor: [
                    'rgb(255, 99, 132)',
        ],
            borderWidth: 1
        }]
        };
        const config = {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
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