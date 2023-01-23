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
                        <p></p>
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
                    <h3 class="card-title">Tax Rates</h3>
                </div>
                <form action="" method="post" id="tax-settings-update" name="tax-settings-update">
                    <div class="card-body">
                        <div class="box-body">
                            <legend>Moon Tax</legend>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="r64-rate">R64</label>
                            <div class="col-md-6">
                                <input id="r64-rate" name="r64-rate" type="number" class="form-control input-md" value="10" min="0" max="100">
                            </div>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="r32-rate">R32</label>
                            <div class="col-md-6">
                                <input id="r32-rate" name="r32-rate" type="number" class="form-control input-md" value="10" min="0" max="100">
                            </div>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="r16-rate">R16</label>
                            <div class="col-md-6">
                                <input id="r16-rate" name="r16-rate" type="number" class="form-control input-md" value="10" min="0" max="100">
                            </div>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="r8-rate">R8</label>
                            <div class="col-md-6">
                                <input id="r8-rate" name="r8-rate" type="number" class="form-control input-md" value="10" min="0" max="100">
                            </div>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="r4-rate">R4</label>
                            <div class="col-md-6">
                                <input id="r4-rate" name="r4-rate" type="number" class="form-control input-md" value="10" min="0" max="100">
                            </div>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="ice-rate">ICE</label>
                            <div class="col-md-6">
                                <input id="ice-rate" name="ice-rate" type="number" class="form-control input-md" value="10" min="0" max="100">
                            </div>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="ore-rate">R8</label>
                            <div class="col-md-6">
                                <input id="ore-rate" name="ore-rate" type="number" class="form-control input-md" value="10" min="0" max="100">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
