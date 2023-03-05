@extends('web::layouts.grids.12')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush


@section('full')
    @isset($result)
        <div class="card">
            <div class="card-header">
                <h3>Detected Bad Boys</h3>
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
                        @if(!empty($result))
                            @foreach($result as $r)
                                <tr>
                                    <td>{{ $r->character_id }}</td>
                                    <td></td>
                                    <td>{{ $r->corporation_id }}</td>
                                    <td>{{ $r->observer_id }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        @else
                        <tr>
                            <td>98143327</td>
                            <td>Hans Peter</td>
                            <td>Renecance</td>
                            <td>J-OAH2</td>
                            <td>P7M1 private</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @endisset
@stop
