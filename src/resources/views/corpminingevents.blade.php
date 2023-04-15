@extends('web::layouts.grids.12')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
<link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush

@section('left')
    @if($errors->any())
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Error !</h4>
            <p>{{$errors->first()}}</p>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div id="overlay" style="border-radius: 5px">
                <div class="w-100 d-flex justify-content-center align-items-center">
                    <div class="spinner"></div>
                </div>
            </div>
        </div>
    </div>
@stop

