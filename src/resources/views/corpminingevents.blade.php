@extends('web::layouts.grids.12')

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
        </div>
        <form action="{{ route('corpminingtax.eventcmd') }}" method="post" id="eventcmd" name="eventcmd">
            {{ csrf_field() }}
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <p>
                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">New Event</button>
                    </p>
                    <div class="collapse" id="collapseExample">
                        <div class="card card-body">

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @isset($eventData)
        <div class="card">
            <div class="card-header">
                <h3>Corp Mining Events</h3>
            </div>
            <div class="card-body">
                <table class="table" id="events">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Event</th>
                        <th>Duration</th>
                        <th>Tax Rate</th>
                        <th>Total Income</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($eventData as $event)
                        <tr>
                            <td>{{ $event->event_start }}</td>
                            <td>{{ $event->event_name }}</td>
                            <td>{{ $event->duration }}</td>
                            <td>{{ $event->tax }}</td>
                            <td></td>
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
        function on() {
            document.getElementById("overlay").style.display = "flex";
        }
    </script>
@endpush