@extends('web::layouts.grids.8-4')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush

@section('left')
    <div class="card">
        <div class="card-header">
            <h3>Settings</h3>
        </div>
        <div class="card-body">
            <div id="overlay" style="border-radius: 5px">
                <div class="w-100 d-flex justify-content-center align-items-center">
                    <div class="spinner">
                    </div>
                </div>
            </div>
            <label>Abyssal ORE Tax</label>
            <input type="text" id="a_ore_tax" name="a_ore_tax">
        </div>
    </div>
@stop
