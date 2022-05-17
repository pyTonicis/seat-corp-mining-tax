@extends('web::layouts.grids.4-4-4')

@section('title', trans('corpminingtax::global.browser_title'))
@section('page_header', trans('corpminingtax::global.page_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush

@section('left')
    <h3>Corp Mining Tax</h3>
    <h5>coming soon...</h5>
@stop