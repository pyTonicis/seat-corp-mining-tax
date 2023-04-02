@extends('web::layouts.grids.8-4')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush


@section('left')
    <div class="card">
        <div class="card-body">
            <div id="overlay" style="border-radius: 5px">
                <div class="w-100 d-flex justify-content-center align-items-center">
                    <div class="spinner"></div>
                </div>
            </div>
            <form action="{{ route('corpminingtax.refinings') }}" method="post" id="refine" name="refine">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="items">Copy and past Raw Ore Material</label>
                    <p>Copy your EvE items wirh (Ctrl+C) in your inventory and past them with (Ctrl+V) into the onput field below and press "Reprocess"</p>
                    <textarea class="w-100" name="items" rows="10"></textarea>
                </div>
                <button type="submit" onclick="on()" class="btn btn-primary" form="item-check">Reprocess</button>
            </form>
        </div>
    </div>
@stop
