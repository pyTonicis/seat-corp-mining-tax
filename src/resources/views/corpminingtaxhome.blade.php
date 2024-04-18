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
                        {{ number_format($minings->mined_total_quantity) }} <small>units</small>
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
                        {{ number_format($minings->mined_total_volume) }} <small>m³</small>
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
                        {{ number_format($minings->mined_total_price) }} <small>ISK</small>
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
                    <span class="info-box-text">Total Tax ISK <small>(last 12 month's)</small></span>
                    <span class="info-box-number">
                        {{ number_format($tax_count) }} <small>ISK</small>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-yellow elevation-1"><i class="fa fa-money-bill-wave"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Tax ISK <small>(this month)</small></span>
                    <span class="info-box-number">
                        {{ number_format($tax_act) }} <small>ISK</small>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-blue elevation-1"><i class="fa fa-trophy"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Top Miners Ranking <small>(this month)</small></span>
                    <span class="info-box-number">
                        {{ $rank }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-orange elevation-1"><i class="fa fa-coins"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Avg. Mined ISK <small>(last 12 month's)</small></span>
                    <span class="info-box-number">
                        {{ number_format($avg_price) }} <small>ISK</small>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-orange elevation-1"><i class="fa fa-money-bill-wave"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Avg. Tax ISK <small>(last 12 month's)</small></span>
                    <span class="info-box-number">
                        {{ number_format($avg_tax) }} <small>ISK</small>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-2 float-right">
                            <select class="custom-select mr-sm-2 align-self-end" name="selected_character" id="selected_character">
                                @foreach($characters as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                    </div>
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
                    <div style="height: 350px">
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
                    <div style="height: 350px">
                        <canvas id="mining_chart2"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mining Tax Report last 12 month's</h3>
                </div>
                <div class="card-body">
                    <table class="table" id="mining_report">
                        <thead>
                        <tr>
                            <td>Date</td>
                            <td>Mined Quantity (units)</td>
                            <td>Mined Volume (m3)</td>
                            <td>Mineral Price (isk)</td>
                            <td>Tax (isk)</td>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($miningdata as $mining)
                                <tr>
                                    <td>{{ $mining->year }}-{{ $mining->month }}</td>
                                    <td>{{ number_format($mining->quantity) }}</td>
                                    <td>{{ number_format($mining->volume) }}</td>
                                    <td>{{ number_format($mining->price) }}</td>
                                    <td>{{ number_format($mining->tax) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
@push('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#mining_report').DataTable({});

            $('#selected_character').on('change', function () {
                var sid = this.value;
                var url = "{{ route('corpminingtax.minedchartdata', [':ids']) }}";
                url = url.replace(':ids', sid);
                var data = 0;
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    timeout: 10000,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        mined_volume_chart.data.datasets[0].data = data.data;
                        mined_volume_chart.update();
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });
        });

        const data = {
            labels: @json($minings->labels),
            datasets: [
                {
                    label: 'Volume m³',
                    data: @json($minings->volume_per_month),
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

        mined_volume_chart = new Chart(document.getElementById('mining_chart').getContext('2d'), config);

        const data2 = {
            labels: @json($minings->labels),
            datasets: @json($dataset),
        };
        const config2 = {
            type: 'bar',
            data: data2,
            options: {
                tooltips: {
                    displayColors: true,
                    callbacks: {
                        label: function(tooltipItem, data2) {
                            return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }, },
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        stacked: true,
                    }],
                    yAxes: [{
                        stacked: true,
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
        mined_groups_chart = new Chart(document.getElementById('mining_chart2').getContext('2d'), config2);

    </script>
@endpush