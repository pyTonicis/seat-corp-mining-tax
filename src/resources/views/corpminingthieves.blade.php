@extends('web::layouts.grids.8-4')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush


@section('left')
    @isset($result)
        <div class="card">
            <div class="card-header">
                <h3>Detected thefts</h3>
            </div>
            <div class="card-body">
                <table class="table datatable compact table-condensed table-hover table-striped" id="mining">
                    <thead>
                    <tr>
                        <th>CharacterID</th>
                        <th>CharacterName</th>
                        <th>Corporation</th>
                        <th>System</th>
                        <th>Moon</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>98143327</td>
                            <td>Hans Peter</td>
                            <td>Renecance</td>
                            <td>J-OAH2</td>
                            <td>P7M1 private</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endisset
@stop
