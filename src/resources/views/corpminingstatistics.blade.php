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
                    <span class="info-box-text">Total Mined Quantity</span>
                    <span class="info-box-number">
                        {{ number_format($total_minings->total_quantity) }} <small>units</small>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-red elevation-1"><i class="fa fa-gem"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Mined Volume</span>
                    <span class="info-box-number">
                        {{ number_format($total_minings->total_volume) }} <small>m³</small>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-green elevation-1"><i class="fa fa-coins"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Mined ISK</span>
                    <span class="info-box-number">
                        {{ number_format($total_minings->total_price) }} <small>ISK</small>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-yellow elevation-1"><i class="fa fa-money-bill-wave"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Incoming Tax ISK</span>
                    <span class="info-box-number">
                        {{ number_format($total_minings->total_tax) }} <small>ISK</small>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-blue elevation-1"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Mining Members</span>
                    <span class="info-box-number">
                        {{ count($total_members) }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-green elevation-1"><i class="fa fa-money-bill-wave"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Incoming from Event's</span>
                    <span class="info-box-number">
                        {{ number_format($total_event_price) }} <small>ISK</small>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><b>Top 5 Miner's </b><small>(over all)</small></h3>
                </div>
                <div class="card-body">
                    <table class="table" id="mining_report">
                        <thead>
                        <tr>
                            <td>Name</td>
                            <td>Mined Quantity (units)</td>
                            <td>Mined Volume (m3)</td>
                            <td>Mineral Price (isk)</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($top_ten_miners as $miner)
                            <tr>
                                <td>{{ $miner->name }}</td>
                                <td>{{ number_format($miner->q) }}</td>
                                <td>{{ number_format($miner->volume) }}</td>
                                <td>{{ number_format($miner->price) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><b>Top 5 Miner's </b><small>(last month)</small></h3>
                </div>
                <div class="card-body">
                    <table class="table" id="mining_report">
                        <thead>
                        <tr>
                            <td>Name</td>
                            <td>Mined Quantity (units)</td>
                            <td>Mined Volume (m3)</td>
                            <td>Mineral Price (isk)</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($top_ten_miners_last_month as $miner)
                            <tr>
                                <td>{{ $miner->name }}</td>
                                <td>{{ number_format($miner->q) }}</td>
                                <td>{{ number_format($miner->volume) }}</td>
                                <td>{{ number_format($miner->price) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mining performance last 12 month`s <small>(all ore types)</small></h3>
                </div>
                <div class="card-body">
                    <div style="height: 350px">
                        <canvas id="mining_chart_over_all"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Corporation Moon Mining's performance last 12 month`s <small>(only Corp Moons)</small></h3>
                </div>
                <div class="card-body">
                    <div style="height: 350px">
                        <canvas id="mining_chart_corp_moons"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mining tax last 12 month`s <small>(isk)</small></h3>
                </div>
                <div class="card-body">
                    <div style="height: 350px">
                        <canvas id="mining_chart_tax"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Event tax last 12 month`s <small>(isk)</small></h3>
                </div>
                <div class="card-body">
                    <div style="height: 350px">
                        <canvas id="mining_chart_events"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@push('javascript')
    <script type="text/javascript">
        $(document).ready(function () {

        const data = {
            labels: @json($chart_labels),
            datasets: [
                {
                    label: 'Volume m³',
                    data: @json($chart_data_over_all),
                    backgroundColor: '#acc239',
                    borderColor: '#acc239',
                    borderWidth: 1
                },
            ]
        };
        const config = {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }, },
                },
                scales: {
                    yAxes: [{
                        beginAtZero: true,
                        ticks: {
                            callback: function(value, index, ticks) {
                                return Intl.NumberFormat().format(value);
                            }
                        }
                    }]
                }
            },
        };

        new Chart(document.getElementById('mining_chart_over_all').getContext('2d'), config);

            const data2 = {
                labels: @json($chart_labels),
                datasets: [
                    {
                        label: 'Volume m³',
                        data: @json($chart_data_moon_minings),
                        backgroundColor: '#ffff00',
                        borderColor: '#ffff00',
                        borderWidth: 1
                    },
                ]
            };
            const config2 = {
                type: 'bar',
                data: data2,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data2) {
                                return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }, },
                    },
                    scales: {
                        yAxes: [{
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, ticks) {
                                    return Intl.NumberFormat().format(value);
                                }
                            }
                        }]
                    }
                },
            };

            new Chart(document.getElementById('mining_chart_corp_moons').getContext('2d'), config2);

            const data3 = {
                labels: @json($chart_labels),
                datasets: [
                    {
                        label: 'ISK',
                        data: @json($chart_data_tax),
                        backgroundColor: '#ffaa00',
                        borderColor: '#ffaa00',
                        borderWidth: 1
                    },
                ]
            };
            const config3 = {
                type: 'bar',
                data: data3,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data3) {
                                return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }, },
                    },
                    scales: {
                        yAxes: [{
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, ticks) {
                                    return Intl.NumberFormat().format(value);
                                }
                            }
                        }]
                    }
                },
            };

            new Chart(document.getElementById('mining_chart_tax').getContext('2d'), config3);

            const data4 = {
                labels: @json($chart_labels),
                datasets: [
                    {
                        label: 'ISK',
                        data: @json($chart_data_events),
                        backgroundColor: '#aaff00',
                        borderColor: '#aaff00',
                        borderWidth: 1
                    },
                ]
            };
            const config4 = {
                type: 'bar',
                data: data4,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data4) {
                                return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }, },
                    },
                    scales: {
                        yAxes: [{
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, ticks) {
                                    return Intl.NumberFormat().format(value);
                                }
                            }
                        }]
                    }
                },
            };

            new Chart(document.getElementById('mining_chart_events').getContext('2d'), config4);

        });
    </script>
@endpush