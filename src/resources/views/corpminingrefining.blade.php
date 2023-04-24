@extends('web::layouts.grids.8-4')

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
            <form action="{{ route('corpminingtax.refinings') }}" method="post" id="refine" name="refine">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="items">Copy and past Raw Ore Material</label>
                    <p>Copy your EvE items wirh (Ctrl+C) in your inventory and past them with (Ctrl+V) into the onput field below and press "Reprocess"</p>
                    <textarea class="w-100" name="items" rows="10"></textarea>
                    <label for="modifier">Ore Refining rate <small>(90% full Skilled with Imps and rigged Tatara)</small></label>
                    <input id="modifier" name="modifier" type="text" class="form-control input-md" value="90.6">
                    <label for="provider">Price Provider</label>
                    <select id="provider" name="provider" type="text" class="form-control input-md">
                        <option value="Eve Market" selected>Eve Market</option>
                        <option value="Eve Praisal">Eve Praisal</option>
                    </select>
                </div>
                <button type="submit" onclick="on()" class="btn btn-primary" form="refine">Reprocess</button>
            </form>
        </div>
    </div>

    @isset($data)
        <div class="card">
            <div class="card-header">
                <h3>Raw Materials</h3>
            </div>
            <div class="card-body">
                <table class="table table-borderless" id="raw_materials">
                    <thead>
                    <tr>
                        <th>Material</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key => $item)
                        <tr>
                            <td><img src="https://images.evetech.net/types/{{ $item["typeID"] }}/icon?size=32"/>{{ $item['categoryID'] }} {{ $item['name'] }} x{{ number_format($item['quantity']) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @isset($data2)
        <div class="card">
            <div class="card-header">
                <h3>Refined Materials</h3>
            </div>
            <div class="card-body">
                <table class="table table-borderless" id="refined_materials">
                    <thead>
                    <tr>
                        <th>Material</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data2 as $key => $item)
                        <tr>
                            <td><img src="https://images.evetech.net/types/{{ $item["typeID"] }}/icon?size=32"/>{{ $item['name'] }}</td>
                            <td>{{ number_format($item['quantity']) }}</td>
                            <td>{{ number_format($item['price'] * $item['quantity']) }}</td>
                        </tr>
                    @endforeach
                        <tr>
                            <td></td>
                            <td>Total Price:</td>
                            <td><b>{{ number_format($total) }} ISK</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @endisset
    @endisset

@stop

@push('javascript')
    @push('javascript')
        <script>
            function on() {
                document.getElementById("overlay").style.display = "flex";
            }
        </script>
    @endpush
    <script>
        table = $('#refined').DataTable({
        });
    </script>
@endpush
