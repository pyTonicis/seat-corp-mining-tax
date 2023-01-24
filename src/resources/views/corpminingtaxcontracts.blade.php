@extends('web::layouts.grids.12')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush

@section('left')
    <div class="card">
        <div class="card-header">
            <h3>Detected thefts</h3>
        </div>
        <div class="card-body">
            <table class="table datatable compact table-condensed table-hover table-striped" id="contracts">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Contract</th>
                    <th>Character</th>
                    <th>Mined ISK</th>
                    <th>Tax ISK</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>12-2022</td>
                    <td>Corporation Mining Tax 9vu331bZ</td>
                    <td>Smasher Jobs</td>
                    <td>3.581.270.000 ISK</td>
                    <td>385.127.000 ISK</td>
                    <td><button type="button" class="btn btn-info">offered</button></td>
                </tr>
                <tr>
                    <td>12-2022</td>
                    <td>Corporation Mining Tax 58jiTt21</td>
                    <td>Mike Jag</td>
                    <td>800.000.000 ISK</td>
                    <td>80.000.000 ISK</td>
                    <td><button type="button" class="btn btn-success">paid</button></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop
