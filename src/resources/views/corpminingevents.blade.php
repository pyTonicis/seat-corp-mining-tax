@extends('web::layouts.grids.12')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('full')
    <div class="card">
        <div class="card-header">
            <h4>Create Event</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('corpminingtax.createevent') }}" method="post" id="new-event" name="new-event">
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="col">
                        <div class="container">
                            <div class="row">
                                <div class='col-sm-6'>
                                    <div class="form-group">
                                        <div class='input-group date datepicker' id='datepicker'>
                                            <input type='text' class="form-control" />
                                            <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @isset($events)
        <div class="card">
            <div class="card-header">
                <h3>Corp Mining Events</h3>
            </div>
            <div class="card-body">
                <div class="col-md">
                    <div class="btn-group submitter-group float-right">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Status</div>
                        </div>
                        <select class="form-control status-dropdown">
                            <option value="">all</option>
                            <option value="1">new</option>
                            <option value="2">running</option>
                        </select>
                    </div>
                </div>
                <table class="table" id="events">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Event</th>
                        <th>Duration</th>
                        <th>Tax Rate</th>
                        <th>Total Income</th>
                        <th>Status</th>
                        <th>Actions</th>
                        <th>Hidden</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($events as $event)
                        <tr>
                            <td>{{ $event->event_start }}</td>
                            <td>{{ $event->event_name }}</td>
                            <td>{{ $event->event_duration }} day(s)</td>
                            <td>{{ $event->event_tax }} %</td>
                            <td>0</td>
                            @if ($event->event_status == 1)
                                <td id="s_{{ $event->id }}"><h5><span class="badge badge-info">new</span></h5></td>
                            @elseif ($event->event_status == 2)
                                <td id="s_{{ $event->id }}"><h5><span class="badge badge-success">running</span></h5></td>
                            @endif
                            <td>
                                <button class="btn btn-warning details" id="d_{{ $event->id }}" data-toggle="modal" data-target="#modal_detail">Edit</button>
                                <button class="btn btn-danger remove" id="r_{{ $event->id }}">Delete</button>
                            </td>
                            <td>{{ $event->event_status }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-yellow">
                                <h4 class="modal-title" id="contract-detail">Contract Details</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default save-data">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endisset
@stop
@push('javascript')
    <script>
        $(document).ready(function() {
            dataTable = $('#events').DataTable({
                "columnDefs": [
                    {
                        "targets": [7],
                        "visible": false
                    }
                ]
            });

            $('.datepicker').flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d H:i",
            });

            $('.status-dropdown').on('change', function (e) {
                var status = $(this).val();
                $('.status-dropdown').val(status)
                console.log(status)
                dataTable.column(7).search(status).draw();
            });

        });
    </script>
@endpush