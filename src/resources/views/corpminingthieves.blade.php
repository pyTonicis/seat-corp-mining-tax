@extends('web::layouts.grids.12')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush


@section('full')
        <div class="card">
            <div class="card-header">
                <h3>Detected Bad Boys</h3>
            </div>
            <div class="card-body">
                <table class="table" id="mining">
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
                        @if(isset($result))
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
                                    <td>No data found</td>
                                </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
@stop
