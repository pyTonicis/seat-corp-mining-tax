@extends('web::layouts.grids.12')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush

@section('full')
    @isset($status)
        <div class="alert alert-success">
            {{ $status }}
        </div>
    @endisset
    @isset($outstanding_contracts)
    <div class="card">
        <div class="card-header">
            <h3>Outstanding Tax</h3>
        </div>
        <div class="card-body">
            <table class="table" id="outstanding">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Contract</th>
                    <th>Character</th>
                    <th>Tax ISK</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($outstanding_contracts as $contract)
                        <tr>
                            <td>{{ $contract->year }}-{{ $contract->month }}</td>
                            <td>{{ $contract->contractTitle }}</td>
                            <td>{{ $contract->character_name}}</td>
                            <td><b>{{ number_format($contract->tax) }}</b></td>
                            <td id="s_{{ $contract->id }}"><h5><span class="badge badge-danger">outstanding</span></h5></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endisset
    <div class="card">
        <div class="card-header">
            <h3>Corporation Tax Contracts</h3>
        </div>
        <div class="card-body">
            <p id="deb"></p>
            <div class="col-md">
                <div class="btn-group submitter-group float-right">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Status</div>
                    </div>
                    <select class="form-control status-dropdown">
                        <option value="">all</option>
                        <option value="1">new</option>
                        <option value="2">offered</option>
                        <option value="3">clear</option>
                        <option value="4">outstanding</option>
                    </select>
                </div>
            </div>
            <table class="table" id="contracts">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Contract</th>
                    <th>Character</th>
                    <th>Tax ISK</th>
                    <th>Status</th>
                    <th>Actions</th>
                    <th>Hidden</th>
                </tr>
                </thead>
                <tbody>
                @isset($contracts)
                    @foreach($contracts as $contract)
                        <tr>
                            <td>{{ $contract->year }}-{{ $contract->month }}</td>
                            <td>{{ $contract->contractTitle }}</td>
                            <td>{{ $contract->character_name}}</td>
                            <td><b>{{ number_format($contract->tax) }}</b></td>
                            @if($contract->contractStatus == 1)
                                <td id="s_{{ $contract->id }}"><h5><span class="badge badge-info">new</span></h5></td>
                            @elseif($contract->contractStatus == 2)
                                <td id="s_{{ $contract->id }}"><h5><span class="badge badge-primary">offered</span></h5></td>
                            @elseif($contract->contractStatus == 3)
                                <td id="s_{{ $contract->id }}"><h5><span class="badge badge-success">completed</span></h5></td>
                            @elseif($contract->contractStatus == 4)
                                <td id="s_{{ $contract->id }}"><h5><span class="badge badge-danger">outstanding</span></h5></td>
                            @endif
                            <td>
                                <button class="btn btn-warning details" id="d_{{ $contract->id }}" data-toggle="modal" data-target="#modal_detail" data-id="{{ $contract->id }}">Edit</button>
                                <button class="btn btn-primary offer" id="o_{{ $contract->id }}">Offer</button>
                                <button class="btn btn-success compl" id="c_{{ $contract->id }}">Complete</button>
                                <button class="btn btn-danger remove" id="r_{{ $contract->id }}">Delete</button>
                            </td>
                            <td>{{ $contract->contractStatus }}</td>
                        </tr>
                    @endforeach
                @endisset
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
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@push('javascript')
    <script>
        $(document).ready(function() {
            dataTable = $('#contracts').DataTable({
                "columnDefs": [
                    {
                        "targets": [6],
                        "visible": false
                    }
                ]
            });

            table = $('#outstanding').DataTable({
            });

            $('.status-dropdown').on('change', function (e) {
                var status = $(this).val();
                $('.status-dropdown').val(status)
                console.log(status)
                dataTable.column(6).search(status).draw();
            });

            $('#modal_detail').on('hidden.bs.modal', function () {
                $('.modal-body').html("");
            });

            $('#contracts').on('click', '.details', function(e) {
                var cid = $(this).attr('id');
                cid = cid.replace('d_', '');
                var url = "{{ route('corpminingtax.contractdata', [':cid']) }}";
                url = url.replace(':cid', cid);
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


            $('#contracts').on('click', '.offer', function() {
                var cid = $(this).attr('id');
                cid = cid.replace('o_', '');
                if (cid > 0) {
                    var url = "{{ route('corpminingtax.contractstatus', [':cid']) }}";
                    url = url.replace(':cid', cid);
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            cid: cid,
                        },
                        success: function() {
                            document.getElementById('s_' + cid).innerHTML = "<h5><span class='badge badge-primary'>offered</span>";
                        }
                    });
                }
            });

            $('#contracts').on('click', '.compl', function() {
                var cid = $(this).attr('id');
                cid = cid.replace('c_', '');
                if (cid > 0) {
                    var url = "{{ route('corpminingtax.complitecontract', [':cid']) }}";
                    url = url.replace(':cid', cid);
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            cid: cid,
                        },
                        success: function() {
                            document.getElementById('s_' + cid).innerHTML = "<h5><span class='badge badge-success'>completed</span>";
                        }
                    });
                }
            });

            $('#contracts').on('click', '.remove', function() {
                var cid = $(this).attr('id');
                cid = cid.replace('r_', '');
                if (cid > 0) {
                    var url = "{{ route('corpminingtax.contractremove', [':cid']) }}";
                    url = url.replace(':cid', cid);
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            cid: cid,
                        },
                        success: function() {
                            document.getElementById('s_' + cid).innerHTML = "<h5><span class='badge badge-danger'>deleted</span>";
                        }
                    });
                }
            });

            $('#modal_detail').on('click', '.copy-data', function (e) {
                var currentRow = $(this).closest("tr");
                var buffer = currentRow.find("td:eq(1)").html();

                copytext(buffer, this);
                $(this).attr('data-original-title', 'Copied !')
                    .tooltip('show');

                $(this).attr('data-original-title', 'Copy to clipboard');
            });
        });

        function copytext(text, context) {
            var textField = document.createElement('textarea');
            textField.innerText = text;
            if (context) {
                context.parentNode.insertBefore(textField, context);
            } else {
                document.body.appendChild(textField);
            }
            textField.select();
            document.execCommand('copy');
            textField.remove();
        }
    </script>
@endpush