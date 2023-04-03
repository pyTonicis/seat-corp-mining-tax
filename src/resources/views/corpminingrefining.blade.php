@extends('web::layouts.grids.8-4')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush


@section('left')
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
                <table class="table" id="raw_materials">
                    <thead>
                    <tr>
                        <th>Material</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key => $item)
                        <tr>
                            <td><img src="https://images.evetech.net/types/{{ $item["typeID"] }}/icon?size=32"/>{{ $item['name'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>0</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3>Refined Materials</h3>
            </div>
            <div class="card-body">
                <table class="table" id="refined_materials">
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
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ number_format($item['price'] * $item['quantity']) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
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
