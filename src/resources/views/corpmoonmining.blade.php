@extends('web::layouts.grids.8-4')

@section('title', 'Moonmining')

@section('left')
<div id="accordion">
    <div class="card">
        <div class="card-header border-secondary" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1" id="heading_1">
            <h5 class="mb-0">
                <div class="row">
                    <h2><span class="badge badge-primary">R16</span></h2>
                    <div class="col-md-8 align-left">
                        <button class="btn">
                            <h3 class="card-title"><b>J-OAH2</b>
                            </h3>
                        </button>
                    </div>
                    <div class="ml-auto mr-2 align-right text-center align-centered">
                        <div class="row">
                            <h4>PRIVATE P7M2 PRESSE <span class="badge badge-success">Active</span></h4>
                        </div>
                    </div>
                </div>
            </h5>
        </div>
        <div id="collapse1" class="collapse" aria-labelledby="heading_1" data-parent="#accordion">
            <div class="card-body">
                <table class="table table-borderless">
                    <tbody>
                    <tr>
                        <td>first</td>
                        <td>second</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop
