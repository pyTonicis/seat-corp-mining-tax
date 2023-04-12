@extends('web::layouts.grids.12')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush

@section('full')
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <form action="{{ route('corpminingtax.contractfilter') }}" method="post" id="contract_filter" name="contract_filter">
                    {{ csrf_field() }}
                <label><strong>Status :</strong></label>
                <select id='status' class="form-control" style="width: 200px">
                    <option value="">--Select Status--</option>
                    <option value="1">new</option>
                    <option value="2">offered</option>
                    <option value="3">complete</option>
                    <option value="4">open</option>
                </select>
                <button type="submit" class="btn btn-primary" id="filter">Filter</button>
                </form>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3>Corporation Tax Contracts</h3>
        </div>
        <div class="card-body">
            <p id="deb"></p>
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
                            @if($contract->contractStatus == 1)
                                <td><span class="badge badge-info">new</span></td>
                            @elseif($contract->contractStatus == 2)
                                <td><span class="badge badge-primary">offered</span></td>
                            @elseif($contract->contractStatus == 3)
                                <td><span class="badge badge-success">complete</span></td>
                                        @elseif($contract->contractStatus == 4)
                                            <td><span class="badge badge-danger">open</span></td>
                            @endif
                            <td>
                                <button class="btn btn-primary offer" id="offer" data-toggle="modal" data-target="#modal_detail" data-id="{{ $contract->id }}">Details</button>
                                <button type="button" class="btn btn-success" id="activate" data-id="{{ $contract->id }}">Activate</button>
                                <button type="button" class="btn btn-danger" id="delete" data-id="{{ $contract->id }}">Delete</button>
                            </td>
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
                            <table class="table table-sm no-border">
                                <tbody>
                                <tr>
                                    <td><b>Contract to</b></td>
                                    <td id="c_name"></td>
                                    <td><button class='btn' onclick="copyToClipboard('c_name')" data-copy='#c_name' data-done='copied'><i class='fas fa-copy'></i></button></td>
                                </tr>
                                <tr>
                                    <td><b>Contract Title</b></td>
                                    <td id="c_title"></td>
                                    <td><button class='btn' onclick="copyToClipboard('c_title')" data-copy='#c_title' data-done='copied'><i class='fas fa-copy'></i></button></td>
                                </tr>
                                <tr>
                                    <td><b>Contract Type</b></td>
                                    <td>Item Exchange</td>
                                </tr>
                                <tr>
                                    <td><b>ISK to pay</b></td>
                                    <td id="c_tax"></td>
                                    <td><button class='btn' onclick="copyToClipboard('c_tax')" data-copy='#c_tax' data-done='copied'><i class='fas fa-copy'></i></button></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="confirm" data-dismiss="modal">Offered</button>
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

        $('#offer').on('click', function(){
            var cid = $(this).attr('data-id');

            if(cid > 0) {
                var url = "{{ route('corpminingtax.contractdata', [':cid']) }}";
                url = url.replace(':cid',cid);

                $.ajax({
                    url: url,
                    type: "GET",
                    datatype: 'json',
                    success: function(data) {
                        //$('.modal-body').html(data.html);
                        $('#c_name').innerText(data.character_name);
                        $('#modal_detail').modal('show');
                    }
                });
            }
        });

        function copyToClipboard(id) {
            let text = document.getElementById(id).innerHTML;
            const copyContent = async () => {
                try {
                    await navigator.clipboard.writeText(text);
                } catch (err) {
                    console.error('Failed to copy', err);
                }
            }
        }
    </script>
@endpush
