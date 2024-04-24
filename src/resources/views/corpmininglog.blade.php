@extends('web::layouts.grids.12')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush

@section('full')
    @isset($miningdata)
        <div class="card">
            <div class="card-header">
                <h3>Mining Logbook</h3>
            </div>
            <div class="card-body">
                <table class="table" id="mining_report">
                    <thead>
                    <tr>
                        <td>Date</td>
                        <td>Character</td>
                        <td>Mined Quantity (units)</td>
                        <td>Mined Volume (m3)</td>
                        <td>Mineral Price (isk)</td>
                        <td>Tax (isk)</td>
                        <td>Event Tax (isk)</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($miningdata as $mining)
                        <tr>
                            <td>{{ $mining->year }}-{{ $mining->month }}</td>
                            <td>{{ $mining->name }}</td>
                            <td>{{ number_format($mining->quantity) }}</td>
                            <td>{{ number_format($mining->volume) }}</td>
                            <td>{{ number_format($mining->price) }}</td>
                            <td>{{ number_format($mining->tax) }}</td>
                            <td>{{ $mining->event_tax }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endisset
@stop
@push('javascript')
    <script>
        $(document).ready(function () {
            $('#mining_report').DataTable({});

        });
    </script>
@endpush
