@extends('web::layouts.grids.8-4')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush


@section('left')
    <div class="card">
        <div class="card-header">
            <h3>Corporation Mining Thieves</h3>
        </div>
        <div class="card-body">
            <div id="overlay" style="border-radius: 5px">
                <div class="w-100 d-flex justify-content-center align-items-center">
                    <div class="spinner">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @isset($result)
        <div class="card">
            <div class="card-header">
                <h3>Bla bla</h3>
            </div>
            <div class="card-body">
                <table class="table" id="mining">
                    <thead>
                    <tr>
                        <th>CharacterID</th>
                        <th>CharacterName</th>
                        <th>Corporation</th>
                        <th>ObserverID</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1234</td>
                            <td>Hans Peter</td>
                            <td>9813357</td>
                            <td>35543992</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endisset
@stop