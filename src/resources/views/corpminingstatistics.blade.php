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
                        {{ number_format($total_quantity) }} <small>units</small>
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
                        {{ number_format($total_volume) }} <small>m³</small>
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
                        {{ number_format($total_price) }} <small>ISK</small>
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
                        {{ number_format($total_tax) }} <small>ISK</small>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-blue elevation-1"><i class="fa fa-trophy"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Mining Members <small>(last 12 month's)</small></span>
                    <span class="info-box-number">
                        {{ $total_members }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Top 5 Miner's <small>(over all)</small></h3>
                </div>
                <div class="card-body">
                    <table class="table" id="top_miners">
                        <thead>
                        <tr>
                            <td>Character</td>
                            <td>Mined Quantity (units)</td>
                            <td>Mined Volume (m3)</td>
                            <td>Mineral Price (isk)</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($top_ten_miners as $miner)
                            <tr>
                                <td>{{ $miner->name }}</td>
                                <td>{{ number_format($mining->quantity) }}</td>
                                <td>{{ number_format($mining->volume) }}</td>
                                <td>{{ number_format($mining->price) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop