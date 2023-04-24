@extends('web::layouts.grids.8-4')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush


@section('left')
<div class="card">
    <div class="card-header">
        <h3>Calculate Mining Tax</h3>
    </div>
    <div class="card-body">
        <div id="overlay" style="border-radius: 5px">
            <div class="w-100 d-flex justify-content-center align-items-center">
                <div class="spinner">
                </div>
            </div>
        </div>
        <form action="{{ route('corpminingtax.data') }}" method="post" id="miningDate" name="miningDate">
            {{ csrf_field() }}
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="mining_month">Month</label>
                    <select class="custom-select mr-sm-2" name="mining_month" id="mining_month">
                        <option value="1" selected>January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="mining_year">Year</label>
                    <select class="custom-select mr-sm-2" name="mining_year" id="mining_year">
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023" selected>2023</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="corpId">Corporation</label>
                    <select class="groupSearch form-control input-xs" name="corpId" id="corpId"></select>
                </div>
            </div>
            <button class="btn btn-primary" onclick="on()" type="submit">Send</button>
        </form>
    </div>
</div>
@isset($miningData)
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-8 align-left">
                <h3>Mining Tax Summary - {{ ($miningData->month < 10) ? "0" . $miningData->month : $miningData->month }}/{{ $miningData->year }}</h3>
            </div>
            <div class="ml-auto mr-2 align-right text-right align-centered">
                <h4>Total Tax <small>(this month)</small> {{ number_format($miningData->getTotalTax()) }} ISK</h4>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="table" id="mining">
            <thead>
            <tr>
                <th>CharacterName</th>
                <th>Mined units</th>
                <th>Mined volume</th>
                <th>Mineral price</th>
                <th>Tax</th>
            </tr>
            </thead>
            <tbody>
            @foreach($miningData->characterData as $character)
                <tr>
                    <td>{{ $character->characterName }}</td>
                    <td>{{ number_format($character->quantity) }}</td>
                    <td>{{ number_format($character->volume) }}</td>
                    <td>{{ number_format($character->priceSummary) }}</td>
                    <td>{{ number_format($character->tax) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endisset
@isset($taxdata)
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8 align-left">
                    <h3>Mining Tax Summary <small>(this month)</small></h3>
                </div>
                <div class="ml-auto mr-2 align-right text-right align-centered">
                    <h4>Total Tax <small>(this month)</small> {{ number_format($total_tax) }} ISK</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table" id="mining">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>CharacterName</th>
                    <th>Mined units</th>
                    <th>Mined volume</th>
                    <th>Mineral Price</th>
                    <th>Tax</th>
                </tr>
                </thead>
                <tbody>
                @foreach($taxdata as $character)
                    <tr>
                        <td>{{ $character->year }}-{{ $character->month }}</td>
                        <td>{{ $character->name }}</td>
                        <td>{{ number_format($character->quantity) }}</td>
                        <td>{{ number_format($character->volume) }}</td>
                        <td>{{ number_format($character->price) }}</td>
                        <td>{{ number_format($character->tax) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endisset
@stop

@push('javascript')
    @push('javascript')
        <script>
            function on() {
                document.getElementById("overlay").style.display = "flex";
            }
        </script>
    @endpush
    <script>
        table = $('#mining').DataTable({
        });

        $('#corpId').select2({
            placeholder: 'Corporation Name',
            ajax: {
                url: '/corpminingtax/getCorporations',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

    </script>
@endpush