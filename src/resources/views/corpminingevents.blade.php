@extends('web::layouts.grids.12')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('full')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h4>Create Event</h4>
        </div>
        <div class="card-body">
            <p id="deb"></p>
            @isset($status)
            <p>{{ $status }}</p>
            @endisset
            <form action="{{ route('corpminingtax.createevent') }}" method="post" id="new-event" name="new-event">
                {{ csrf_field() }}
                <div class="form-row">
                        <label for="event">Event Name</label>
                        <input type="text" class="form-control" id="event" name="event">
                </div>
                <div class="form-row">
                    <div class="col-7">
                        <label for="start">Start Date</label>
                        <input type='text' class="form-control datepicker" id="start" name="start" placeholder="Select Date..">
                    </div>
                    <div class="col">
                        <label for="duration">Duration <small>days</small></label>
                        <input type="number" class="form-control" id="duration" name="duration">
                    </div>
                    <div class="col">
                        <label for="taxrate">Tax Rate %</label>
                        <input type="number" class="form-control" id="taxrate" name="taxrate">
                    </div>
                </div>
                <div class="form-row">
                    <p></p>
                </div>
                <button type="submit" class="btn btn-primary" id="send">Add Event</button>
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
                            <option value="3">completed</option>
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
                        <th>Total Income ISK</th>
                        <th>Status</th>
                        <th>Actions</th>
                        <th>Hidden</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($events as $event)
                        <tr id="tr_{{ $event->id }}">
                            <td>{{ date("Y-m-d", strtotime($event->event_start) }}</td>
                            <td><b>{{ $event->event_name }}</b></td>
                            <td>{{ $event->event_duration }} day(s)</td>
                            <td>{{ $event->event_tax }} %</td>
                            <td>{{ number_format($event->total) }}</td>
                            @if ($event->event_status == 1)
                                <td id="s_{{ $event->id }}"><h5><span class="badge badge-info">new</span></h5></td>
                            @elseif ($event->event_status == 2)
                                <td id="s_{{ $event->id }}"><h5><span class="badge badge-warning">running</span></h5></td>
                            @elseif ($event->event_status == 3)
                                <td id="s_{{ $event->id }}"><h5><span class="badge badge-success">complete</span></h5></td>
                            @endif
                            <td>
                                <button class="btn btn-warning details" id="d_{{ $event->id }}" data-toggle="modal" data-target="#modal_detail">Edit</button>
                                <button class="btn btn-danger delete" id="r_{{ $event->id }}">Delete</button>
                            </td>
                            <td>{{ $event->event_status }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
                enableTime: false,
                dateFormat: "Y-m-d",
            });

            $('.status-dropdown').on('change', function (e) {
                var status = $(this).val();
                $('.status-dropdown').val(status)
                console.log(status)
                dataTable.column(7).search(status).draw();
            });

            $('.details').on('click', function(e) {
                var cid = $(this).attr('id');
                cid = cid.replace('d_', '');
                var url = "{{ route('corpminingtax.eventdetails', [':eid']) }}";
                url = url.replace(':eid', cid);
                $.ajax({
                    url: url,
                    type: "GET",
                    datatype: 'json',
                    timeout: 10000,
                    success: function (data) {
                        $('.modal-body').html(data);
                        $('#modal_detail').modal('show');
                    }
                });
            });

            $('.add-mining').on('click', function() {
                var cid = $(this).attr('id');
                cid = cid.replace('a_', '');
                document.getElementById('deb').innerText = $('#character').val();
                if (cid > 0) {
                    var url = "{{ route('corpminingtax.addmining') }}";
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            eid: cid,
                            character: $('#character').val(),
                            ore: $('#ore').val(),
                        }
                    });
                }
            });

            $(document).on('click', '.remove', function() {
                var cid = $(this).attr('id');
                cid = cid.replace('r_', '');
                if (cid > 0) {
                    var url = "{{ route('corpminingtax.removeeventmining') }}";
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            cid: cid,
                        },
                        success: function () {
                            var tag_mod = "#mod_" + cid;
                            $(tag_mod).remove();
                        }
                    });
                }
            });

            $('.delete').on('click', function() {
                var cid = $(this).attr('id');
                cid = cid.replace('r_', '');
                if (cid > 0) {
                    var url = "{{ route('corpminingtax.removeevent') }}";
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            cid: cid,
                        },
                        success: function () {
                            var tag = "#tr_" + cid;
                            $(tag).remove();
                        }
                    });
                }
            });

        });
    </script>
@endpush