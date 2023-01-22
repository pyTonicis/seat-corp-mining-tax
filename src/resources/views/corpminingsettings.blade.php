@extends('web::layouts.grids.12')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush

@section('full')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">General Settings</h3>
                </div>
                <form action="" method="post" id="settings-update" name="settings-update">
                    <div class="card-body">
                        <div class="box-body">
                            <legend>Global Settings</legend>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="ore-price-modify">Ore Refining Rate</label>
                            <div class="col-md-6">
                                <input id="ore-refining-rate" name="ore-refining-rate" type="number" class="form-control input-md" value="91" min="0" max="100">
                            </div>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="ore-valuation-price">Ore Valuation Price</label>
                            <div class="col-md-6">
                                <select class="custom-select mr-sm-2" name="ore-valuation-price" id="ore-valuation-price">
                                    <option value="1">Ore Price</option>
                                    <option value="2">Mineral Price</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="ore-price-provider">Price Provider</label>
                            <div class="col-md-6">
                                <select class="custom-select mr-sm-2" name="ore-price-provider" id="ore-price-provider">
                                    <option value="1">Eve Market</option>
                                    <option value="2">Eve Praisal</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="price-modifier">Price Modifier</label>
                            <div class="col-md-6">
                                <input id="price-modifier" name="price-modifier" type="number" class="form-control input-md" value="98" min="0" max="100">
                            </div>
                        </div>
                        <div class="box-body">
                            <legend>Contract Settings</legend>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="contract-holder">Price Modifier</label>
                            <div class="col-md-6">
                                <input id="contract-holder" name="contract-holder" type="text" class="form-control input-md" value="DollarBoy">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md4 col-form-label" for="contract-exprie">Expries in</label>
                            <select class="custom-select mr-sm-2" name="contract-exprie" id="contract-exprie">
                                <option value="1">1 Day</option>
                                <option value="2">2 Days</option>
                                <option value="3">3 Days</option>
                                <option value="4">1 Week</option>
                                <option value="5">4 Weeks</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Information</h3>
                </div>
            <div class="card-body">
                <p>Hier könnte Ihre Werbung stehen!</p>
                <p>Wenn Sie keine Werbung wünschen, zahlen Sie bitte 10B ISK an mich :)</p>
            </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tax Rates</h3>
                </div>
                <form action="" method="post" id="tax-settings-update" name="tax-settings-update">
                    <div class="card-body">
                        <div class="box-body">
                            <legend>Moon Tax</legend>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="ore-price-modify">R64</label>
                            <div class="col-md-6">
                                <input id="r64-rate" name="r64-rate" type="number" class="form-control input-md" value="10" min="0" max="100">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop<
