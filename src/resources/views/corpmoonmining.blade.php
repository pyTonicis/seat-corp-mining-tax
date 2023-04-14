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
                        @if($d->group == 1884)
                            <span class="badge badge-secondary">R4</span>
                        @elseif($d->group == 1920)
                            <span class="badge badge-info">R8</span>
                        @elseif($d->group == 1921)
                            <span class="badge badge-success">R16</span>
                        @elseif($d->group == 1922)
                            <span class="badge badge-warning">R32</span>
                        @elseif($d->group == 1923)
                            <span class="badge badge-danger">R64</span>
                        @endif
                    </h3>
                    <div class="col-md-8 align-left">
                        <button class="btn">
                            <h3 class="card-title"><b>{{ $d->observer_name }}</b></h3>
                        </button>
                    </div>
                    <div class="ml-auto mr-2 align-center text-center align-centered">
                        <span class="info-box-icon bg-blue elevation-1"><i class="fa-solid fa-arrow-down-to-line"></i></span>
                    </div>
                    <div class="ml-auto mr-2 align-right text-center align-centered">
                        <div class="row">
                            <h4>Total Mined: <b>{{ number_format($d->get_total_quantity() * 10) }} m³ {{ number_format($d->get_total_mined_isk()) }} ISK</b></h4>
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
                    @foreach ($d->minings as $mining)
                        <tr>
                        <td>{{ $mining->date }}</td>
                        <td>??%</td>
                        <td>{{ number_format($mining->quantity * 10) }}</td>
                        <td>{{ $mining->get_ore_types() }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        @endforeach
</div>
@endisset
@stop
