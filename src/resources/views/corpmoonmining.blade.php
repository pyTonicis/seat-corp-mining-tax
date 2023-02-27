@extends('web::layouts.grids.8-4')

@section('title', 'Moonmining')

@section('left')
    @isset($data)

            <div class="card">
            <div class="card-header">
                <h3>{{ $d->name }}</h3>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Strcuture ID</th>
                        <th>Structure Name</th>
                        <th>Last Extraction</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $d)
                        <tr>
                            <td>{{ $d->observer_id }}</td>
                            <td>{{ $d->name }}</td>
                            <td>{{ $extractions->$d->observer_id }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endisset
@stop