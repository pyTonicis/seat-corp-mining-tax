@extends('web::layouts.grids.8-4')

@section('title', trans('corpminingtax::global.browser_title'))
@section('page_header', trans('corpminingtax::global.page_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush

@section('left')
<div class="card">
    <div class="card-header">
        <h3>Settings</h3>
    </div>
    <div class="card-body">
        <form class="needs-validation" novalidate>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="mining_month">Month</label>
                    <select class="custom-select mr-sm-2" id="mining_month">
                        <option value="0">January</option>
                        <option value="1">February</option>
                        <option value="2">March</option>
                        <option value="3">April</option>
                        <option value="4">May</option>
                        <option value="5">June</option>
                        <option value="6">July</option>
                        <option value="7">August</option>
                        <option value="8">September</option>
                        <option value="9">October</option>
                        <option value="10">November</option>
                        <option value="11">December</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="mining_year">Year</label>
                    <select class="custom-select mr-sm-2" id="mining_year">
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                    </select>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">Send</button>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h3>Results</h3>
    </div>
    <div class="card-body">

        <table class="table" id="mining">
            <thead>
            <tr>
                <th>Test 1</th>
                <th>Test 2</th>
                <th>Test 3</th>
                <th>Test 4</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
            </tr>
            <tr>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
            </tr>
            <tr>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
            </tr>
            <tr>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
@stop

@push('javascript')
    <script>
        table = $('#mining').DataTable({
        });
    </script>
@endpush