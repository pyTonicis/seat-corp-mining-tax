@extends('web::layouts.grids.12')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush

@section('full')
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label><strong>Status :</strong></label>
                <select id='status' class="form-control" style="width: 200px">
                    <option value="">--Select Status--</option>
                    <option value="1">new</option>
                    <option value="2">offered</option>
                    <option value="3">complete</option>
                    <option value="4">open</option>
                </select>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3>Corporation Tax Contracts</h3>
        </div>
        <div class="card-body">
            <table class="table" id="contracts">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Contract</th>
                    <th>Character</th>
                    <th>Tax ISK</th>
                    <th>Status</th>
                    <th>Actions</th>
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
                                <h3><b>
                            @if($contract->contractStatus == 1)
                                <td><span class="badge badge-info">new</span></td>
                            @elseif($contract->contractStatus == 2)
                                <td><span class="badge badge-primary">offered</span></td>
                            @elseif($contract->contractStatus == 3)
                                <td><span class="badge badge-success">complete</span></td>
                                        @elseif($contract->contractStatus == 4)
                                            <td><span class="badge badge-danger">open</span></td>
                            @endif
                                </b></h3>
                            <td>
                                <button class="btn btn-info viewdetails" data-id="{{ $contract->id }}">Details</button>
                            </td>
                        </tr>
                    @endforeach
                @endisset
                </tbody>
            </table>
            <div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="myinfo"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@push('javascript')
    <script>
        table = $('#contracts').DataTable({
        });

        $('#modal_detail').on('click', '.viewdetails', function(){
            var cid = $(this).attr('data-id');

            if(cid > 0) {
                var url = "{{ route('corpminingtax.contractdata', [':cid']) }}";
                url = url.replace(':cid','cid');

                $('#myinfo').empty();

                $.ajax({
                    url: url,
                    dataType: 'json',
                    success: function(response) {
                        $('#myinfo').html(response.html);
                        $('#modal_detail').modal('show');
                    }
                });
            }
        });
    </script>
@endpush
