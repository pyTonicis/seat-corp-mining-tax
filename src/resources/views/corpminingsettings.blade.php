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
                            <label class="col-md4 col-form-label" for="ore-price-modify">Ore Price Modifier</label>
                            <div class="col-md-6">
                                <input id="ore-price-modify" name="ore-price-modify" type="number" class="form-control input-md" value="">
                            </div>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="ore-refining-modify">Ore Refining Modifier</label>
                            <div class="col-md-6">
                                <input id="ore-refining-modify" name="ore-refining-modify" type="number" class="form-control input-md" value="">
                            </div>
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
            </div>
            <div class="card-body">
                <p>Hier könnte Ihre Werbung stehen!</p>
                <p>Wenn Sie keine Werbung wünschen, zahlen Sie bitte 10B ISK an mich :)</p>
            </div>
        </div>
    </div>
@stop
