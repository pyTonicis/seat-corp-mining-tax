@extends('web::layouts.grids.12')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush

@section('full')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">General Settings</h3>
                </div>
                <form action="{{ route('corpminingtax.settings.update') }}" method="post" id="settings-update" name="settings-update">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="box-body">
                            <legend>Global Settings</legend>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="corpId">Corporation</label>
                            <div class="col-md-12">
                                <select class="groupSearch form-control input-xs" name="corporation_id" id="corporation_id"></select>
                            </div>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="ore_refining_rate">Ore Refining Rate</label>
                            <div class="col-md-12">
                                <input id="ore_refining_rate" name="ore_refining_rate" type="text" class="form-control input-md" value="{{ $settings['ore_refining_rate'] }}">
                            </div>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="ore_valuation_price">Ore Valuation Price</label>
                            <div class="col-md-12">
                                <select class="custom-select mr-sm-2" name="ore_valuation_price" id="ore_valuation_price">
                                    <option value="Ore Price">Ore Price</option>
                                    <option value="Mineral Price">Mineral Price</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="price_provider">Price Provider</label>
                            <div class="col-md-12">
                                <select class="custom-select mr-sm-2" name="price_provider" id="price_provider">
                                    <option value="Eve Market">Eve Market</option>
                                    <option value="Eve Janice">Eve Janice</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="price_provider_key">Price Provider API Key</label>
                            <div class="col-md-12">
                                <input id="price_provider_key" name="price_provider_key" class="form-control input-md" value="{{ $settings['price_provider_key'] }}">
                            </div>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="price_modifier">Price Modifier</label>
                            <div class="col-md-12">
                                <input id="price_modifier" name="price_modifier" type="number" class="form-control input-md" value="{{ $settings['price_modifier'] }}" min="0" max="100">
                            </div>
                        </div>
                        <p></p>
                        <div class="box-body">
                            <legend>Contract Settings</legend>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="contract_issuer">Contract Issuer Character Name</label>
                            <div class="col-md-12">
                                <input id="contract_issuer" name="contract_issuer" type="text" class="form-control input-md" value="{{ $settings['contract_issuer'] }}">
                            </div>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="contract_tag">Contract Tag</label>
                            <div class="col-md-12">
                                <input id="contract_tag" name="contract_tag" type="text" class="form-control input-md" value="{{ $settings['contract_tag'] }}">
                            </div>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="contract_min">Contract minimal tax value<small>(isk)</small></label>
                            <div class="col-md-12">
                                <input id="contract_min" name="contract_min" type="text" class="form-control input-md" value="{{ $settings['contract_min'] }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="col-md4 col-form-label" for="contract_expire">Expire in</label>
                            <input id="contract_expire" name="contract_expire" type="text" class="form-control input-md" value="{{ $settings['contract_expire'] }}">
                        </div>
                        <div class="box-body">
                            <legend>Moon Tax</legend>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="r64_rate">R64</label>
                            <div class="col-md-12">
                                <input id="r64_rate" name="r64_rate" type="number" class="form-control input-md" value="{{ $settings['r64_rate'] }}" min="0" max="100">
                            </div>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="r32_rate">R32</label>
                            <div class="col-md-12">
                                <input id="r32_rate" name="r32_rate" type="number" class="form-control input-md" value="{{ $settings['r32_rate'] }}" min="0" max="100">
                            </div>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="r16_rate">R16</label>
                            <div class="col-md-12">
                                <input id="r16_rate" name="r16_rate" type="number" class="form-control input-md" value="{{ $settings['r16_rate'] }}" min="0" max="100">
                            </div>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="r8_rate">R8</label>
                            <div class="col-md-12">
                                <input id="r8_rate" name="r8_rate" type="number" class="form-control input-md" value="{{ $settings['r8_rate'] }}" min="0" max="100">
                            </div>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="r4_rate">R4</label>
                            <div class="col-md-12">
                                <input id="r4_rate" name="r4_rate" type="number" class="form-control input-md" value="{{ $settings['r4_rate'] }}" min="0" max="100">
                            </div>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="ice_rate">ICE</label>
                            <div class="col-md-12">
                                <input id="ice_rate" name="ice_rate" type="number" class="form-control input-md" value="{{ $settings['ice_rate'] }}" min="0" max="100">
                            </div>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="ore_rate">ORE</label>
                            <div class="col-md-12">
                                <input id="ore_rate" name="ore_rate" type="number" class="form-control input-md" value="{{ $settings['ore_rate'] }}" min="0" max="100">
                            </div>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="gas_rate">GAS</label>
                            <div class="col-md-12">
                                <input id="gas_rate" name="gas_rate" type="number" class="form-control input-md" value="{{ $settings['gas_rate'] }}" min="0" max="100">
                            </div>
                        </div>
                        <div class="form-group-row">
                            <label class="col-md4 col-form-label" for="abyssal_rate">Abyssal Ore</label>
                            <div class="col-md-12">
                                <input id="abyssal_rate" name="abyssal_rate" type="number" class="form-control input-md" value="{{ $settings['abyssal_rate'] }}" min="0" max="100">
                            </div>
                        </div>
                        <div class="box-body">
                            <legend>Tax Selector</legend>
                        </div>
                        <div class="row">
                            <div class="form-group-row">
                                <div class="form-check form-check-inline">
                                    <input id="taxes_moon" name="taxes_moon" type="checkbox" class="form-check-input" value="true">
                                    <label class="form-check-label" for="taxes_moon">Moon Ore</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input id="taxes_corp_moon" name="taxes_corp_moon" type="checkbox" class="form-check-input" value="true">
                                    <label class="form-check-label" for="taxes-corp-moon">Corp Moon Ore</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input id="taxes_ore" name="taxes_ore" type="checkbox" class="form-check-input" value="true">
                                    <label class="form-check-label" for="taxes_ore">Ore</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input id="taxes_ice" name="taxes_ice" type="checkbox" class="form-check-input" value="true">
                                    <label class="form-check-label" for="taxes_ice">Ice</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input id="taxes_gas" name="taxes_gas" type="checkbox" class="form-check-input" value="true">
                                    <label class="form-check-label" for="taxes_gas">Gas</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input id="taxes_abyssal" name="taxes_abyssal" type="checkbox" class="form-check-input" value="true">
                                    <label class="form-check-label" for="taxes_abyssal">Abyssal Ore</label>
                                </div>
                            </div>
                        </div>
                        <p></p>
                        <button id="submit" type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Settings Info</h3>
                </div>
                <div class="card-body">
                    <div class="box-body">
                        <legend>Global Settings</legend>
                    </div>
                    <h5>Corporation</h5>
                    <p>
                        Select the name of your Corporation (It's important for automatic monthly caluculating)
                    </p>
                    <h5>Ore Refining Rate</h5>
                    <p>
                        Set the maximum refining amount for your members. With implantat, full skill and a rigged Tatara it is 90.6%
                    </p>
                    <h5>Ore Valuation Price</h5>
                    <p>
                        Calculating Price from ore oder minerals (refined). Standard is mineral price.
                    </p>
                    <h5>Price Provider</h5>
                    <p>
                        Chose a price provider to get ore/mineral prices.
                    </p>
                    <h5>Price Modifier</h5>
                    <p>
                        Modify base cost of the ore/minerals to adjust inflation/transport costs. Normal it is 100%.
                    </p>
                    <legend>Contract Settings</legend>
                    <p>
                        Set Character Name of Contract issuer, contract expire time and a "tag" for Contract Description: e.g.: "Mining Tax". In field "Contract minimal tax value" you can set a minimum amount of isk.
                    </p>
                    <legend>Mining Tax</legend>
                    <p>
                        Set Tax Rate for different Ore Groups
                    </p>
                    <legend>Tax Pre-Selector</legend>
                    <p>
                        Select Tax Filters:
                        <ul>
                        <li>Moon Ore = Taxes all Moon Minings</li>
                        <li>Corp Moon Ore = Taxes only Corporation Moon's</li>
                        <li>Ore = Taxes all normal Ore</li>
                        <li>Ice = Taxes all Ice Ore</li>
                        <li>Gas = Taxes all Gas Minings</li>
                        <li>Abyssal = Taxes Abysaal Ore</li>
                        </ul>
                    </p>
                </div>
            </div>
        </div>
    </div>
@stop
@push('javascript')
    <script>
        $('#corporation_id').select2({
            placeholder: '{{ $settings['corporation_name'] }}',
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
        $('#corporation_id').val('{{ $settings['corporation_id'] }}').trigger('change');
        $('#ore_valuation_price').val('{{ $settings['ore_valuation_price'] }}').trigger('change');
        $('#price_provider').val('{{ $settings['price_provider'] }}').trigger('change');
        document.getElementById('taxes_ore').checked = {{ $settings['taxes_ore'] }};
        document.getElementById('taxes_moon').checked = {{ $settings['taxes_moon'] }};
        document.getElementById('taxes_corp_moon').checked = {{ $settings['taxes_corp_moon'] }};
        document.getElementById('taxes_ice').checked = {{ $settings['taxes_ice'] }};
        document.getElementById('taxes_gas').checked = {{ $settings['taxes_gas'] }};
        document.getElementById('taxes_abyssal').checked = {{ $settings['taxes_abyssal'] }};
    </script>
@endpush
