@extends('web::layouts.grids.12')

@section('title', trans('corpminingtax::global.browser_title'))

@section('full')
    <div class="card">
        <div class="card-body">
        <form action="{{ route('corpminingtax.eventcmd') }}" method="post" id="eventcmd" name="eventcmd">
            {{ csrf_field() }}
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <div class="input-group date" data-provide="datepicker">
                        <label for="c_date">Date:</label>
                        <input type="text" class="form-control" id="c_date">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                        <label for="c_duration">Duration:</label>
                        <input type="number" class="form-control" id="c_duration">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <div class="input-group">
                        <label for="c_name">Event Title:</label>
                        <input type="text" class="form-control" id="c_name">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <button class="btn btn-primary" type="submin" id="send">Create</button>
                </div>
            </div>
        </form>
        </div>
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
    <script>
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '-3d'
        });
    </script>
@endpush