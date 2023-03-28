@extends('web::layouts.grids.8-4')

@section('title', 'Moonmining')

@section('left')
<div id="accordion">
    <div class="card">
        <div class="card-header border-secondary" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1" id="heading_1">
            <h5 class="mb-0">
                <div class="row">
                    <h3><span class="badge badge-primary">R16</span></h3>
                    <div class="col-md-8 align-left">
                        <button class="btn">
                            <h3 class="card-title"><b>SolarSystem</b> PRIVATE P7M2 PRESSE</h3>
                        </button>
                    </div>
                    <div class="ml-auto mr-2 align-right text-center align-centered">
                        <div class="row">
                            <h4>Total Mined: <b>34.198.762 m³</b></h4>
                        </div>
                    </div>
                </div>
            </h5>
        </div>
        <div id="collapse1" class="collapse" aria-labelledby="heading_1" data-parent="#accordion">
            <div class="card-body">
                <table class="table table-borderless">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Mined %</th>
                        <th>Volume m³</th>
                        <th>Ore Types</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>2023-01-07</td>
                        <td>34%</td>
                        <td>9.386.712</td>
                        <td>lavish Chromite, Chromite, Sperrylite</td>
                    </tr>
                    <tr>
                        <td>2023-02-18</td>
                        <td>56%</td>
                        <td>19.112.954</td>
                        <td>Lavish Chromite, Chromite, Lavish Euxenite, Sperrylite</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop
