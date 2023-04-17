@extends('web::layouts.grids.12')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush

@section('full')
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
                                <td><h5><span class="badge badge-info">new</span></h5></td>
                            @elseif($contract->contractStatus == 2)
                                <td><h5><span class="badge badge-primary">offered</span></h5></td>
                            @elseif($contract->contractStatus == 3)
                                <td><h5><span class="badge badge-success">clear</span></h5></td>
                            @elseif($contract->contractStatus == 4)
                                <td><h5><span class="badge badge-danger">outstanding</span></h5></td>
                            @endif
                            <td>
                                <button class="btn btn-primary details" id="d_{{ $contract->id }}" data-toggle="modal" data-target="#modal_detail" data-id="{{ $contract->id }}">Details</button>
                                <button class="btn btn-success offer" id="o_{{ $contract->id }}">Activate</button>
                                <button class="btn btn-danger" id="r_{{ $contract->id }}">Delete</button>
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

            $('.status-dropdown').on('change', function (e) {
                var status = $(this).val();
                $('.status-dropdown').val(status)
                console.log(status)
                dataTable.column(6).search(status).draw();
            })

            $('#modal_detail').on('hidden.bs.modal', function () {
                $('.modal-body').html("");
            });

            $(document).on('click', '.copy-data', function (e) {
                var buffer = $(this).data('data-export');
                $('body').append('<textarea id="copied-data"></textarea>');
                $('#copied-data').val(buffer);
                document.getElementById('copied-data').select();
                document.execCommand('copy');
                document.getElementById('copied-data').remove();
                $(this).attr('data-original-title', 'Copied !')
                    .tooltip('show');
                $(this).attr('data-original-title', 'Copy to clipboard');
            });

            $('.details').on('click', function(e) {
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
                        $('.modal-body').html(data.html);
                        //$('#c_name').innerText(data.character_name);
                        $('#modal_detail').modal('show');
                    }
                });
            });

            $('.offer').on('click', function() {
                var cid = $(this).attr('id');
                cid = cid.replace('o_', '');
                document.getElementById('deb').innerText = cid;
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
                    });
                }
            });

            function copyToClipboard(id) {
                let copy_text = document.getElementById(id).innerText;
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(copy_text);
                }
            }
        });
    </script>
@endpush
