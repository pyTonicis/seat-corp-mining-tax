@extends('web::layouts.grids.8-4')

@section('title', 'Moonmining')

@section('left')
<div id="accordion">
    <div class="card">
        <div class="card-header border-secondary" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1" id="heading_1">
            <h5 class="mb-0">
                <div class="row">
                    <i class="nav-icon fas fa-eye align-middle mt-2"></i>
                    <div class="col-md-8 align-left">
                        <button class="btn">
                            <h3 class="card-title"><b>Ein Test</b>
                            </h3>
                        </button>
                    </div>
                    <div class="ml-auto mr-2 align-right text-center align-centered">
                        <div class="row">
                            <h3>Hier könnte Ihre Werbung stehen!</h3>
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
