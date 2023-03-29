@extends('web::layouts.grids.8-4')

@section('title', 'Moonmining')

@section('left')
    @isset($data)
    <div id="accordion">
        @foreach($data->observers as $d)
        <div class="card">
        <div class="card-header border-secondary" data-toggle="collapse" data-target="#collapse_{{ $d->observer_id }}" aria-expanded="true" aria-controls="collapse_{{ $d->observer_id }}" id="heading_{{ $d->observer_id }}">
            <h5 class="mb-0">
                <div class="row">
                    <h3>
                        R16
                    </h3>
                    <div class="col-md-8 align-left">
                        <button class="btn">
                            <h3 class="card-title"><b>{{ $d->observer_name }}</b></h3>
                        </button>
                    </div>
                    <div class="ml-auto mr-2 align-right text-center align-centered">
                        <div class="row">
                            <h4>Total Mined: <b> m³</b></h4>
                        </div>
                    </div>
                </div>
            </h5>
        </div>
        <div id="collapse_{{ $d->observer_id }}" class="collapse" aria-labelledby="heading_{{ $d->observer_id }}" data-parent="#accordion">
            <div class="card-body">
                <table class="table table-borderless">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Mined %</th>
                        <th>Volume m³</th>
                        <th>Ore Types</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>2023-01-07</td>
                        <td>34%</td>
                        <td>9.386.712</td>
                        <td>lavish Chromite, Chromite, Sperrylite</td>
                    </tr>
                    <tr>
                        <td>2023-02-18</td>
                        <td>56%</td>
                        <td>19.112.954</td>
                        <td>Lavish Chromite, Chromite, Lavish Euxenite, Sperrylite</td>
                    </tr>
                    </tbody>
                </table>
                @foreach ($d->minings as $m)
                    <p>{{ $m->date }} {{ $m->quantity }}</p>
                @endforeach
            </div>
        </div>
    </div>
        @endforeach
</div>
@endisset
@stop
