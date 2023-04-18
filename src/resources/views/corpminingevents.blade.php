@extends('web::layouts.grids.12')

@section('title', trans('corpminingtax::global.browser_title'))
@push('body-scripts')
    @once
        <script src="bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    @endonce
@endpush
@section('full')
    @isset($eventData)
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
                    @foreach($eventData as $event)
                        <tr>
                            <td>{{ $event->event_start }}</td>
                            <td>{{ $event->event_name }}</td>
                            <td>{{ $event->duration }}</td>
                            <td>{{ $event->tax }}</td>
                            <td>0</td>
                            <td id="s_{{ $event->id }}"><h5><span class="badge badge-success">running</span></h5></td>
                            <td>
                                <button class="btn btn-warning details" id="d_{{ $event->id }}" data-toggle="modal" data-target="#modal_detail" data-id="{{ $contract->id }}">Edit</button>
                                <button class="btn btn-danger remove" id="r_{{ $event->id }}">Delete</button>
                            </td>
                            <td>{{ $event->event_status }}</td>
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
        $(document).ready(function() {
            dataTable = $('#events').DataTable({
                "columnDefs": [
                    {
                        "targets": [7],
                        "visible": false
                    }
                ]
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