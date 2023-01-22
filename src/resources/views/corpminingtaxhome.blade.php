@extends('web::layouts.grids.12')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush

@section('full')
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Total Quantity</h4>
                </div>
                <div class="card-body">
                    <p>51.000.000 units</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Total Volume</h4>
                </div>
                <div class="card-body">
                    <p>510.000.000 m³</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Total Price</h4>
                </div>
                <div class="card-body">
                    <p>82.169.500.000 ISK</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mining performance last 12 month`s</h3>
                </div>
                <div class="card-body">
                    <div style="height: 200px">
                    <canvas id="mining_chart" height="300"></canvas>
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
                    <table id="mining-log" class="table">
                        <thead>
                        <th class="text-center"><i class="fas fa-arrow-down"></i><i class="fas fa-arrow-up"></i>Date</th>
                        <th class="text-center"><i class="fas fa-arrow-down"></i><i class="fas fa-arrow-up"></i>System</th>
                        <th class="text-center"><i class="fas fa-arrow-down"></i><i class="fas fa-arrow-up"></i>ORE</th>
                        <th class="text-center"><i class="fas fa-arrow-down"></i><i class="fas fa-arrow-up"></i>Quantity</th>
                        <th class="text-center"><i class="fas fa-arrow-down"></i><i class="fas fa-arrow-up"></i>Volume</th>
                        <th class="text-center"><i class="fas fa-arrow-down"></i><i class="fas fa-arrow-up"></i>Est. Value</th>
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
@push('javascript')
    <script type="text/javascript">
        const labels = ["01-22","02-22","03-22","04-22","05-22","06-22","07-22","08-22","09-22","10-22","11-22","12-22"]
        const data = {
            labels: labels,
            datasets: [{
                label: 'Volume in x1000 m³',
                data: [650, 590, 800, 810, 560, 550, 40, 1200, 33000, 540, 1300, 650],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(255, 99, 132, 0.8)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)',
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