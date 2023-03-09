<?php

/*
This file is part of SeAT

Copyright (C) 2015 to 2020  Leon Jacobs

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

namespace pyTonicis\Seat\SeatCorpMiningTax\Database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMiningTaxSettingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mining_tax_settings', function (Blueprint $table) {
            $table->bigInteger('corp_id');
            $table->string('corp_name');
            $table->tinyInteger('ore_refining_rate');
            $table->tinyInteger('ore_valuation_price');
            $table->string('price_provider');
            $table->tinyInteger('price_modifier');
            $table->string('contract_holder');
            $table->string('contract_expire');
            $table->tinyInteger('tax_r64');
            $table->tinyInteger('tax_r32');
            $table->tinyInteger('tax_r16');
            $table->tinyInteger('tax_r8');
            $table->tinyInteger('tax_r4');
            $table->tinyInteger('tax_ore');
            $table->tinyInteger('tax_ice');
            $table->tinyInteger('tax_gas');
            $table->bool('sel_moon_ore');
            $table->bool('sel_corp_moon_ore');
            $table->bool('sel_ore');
            $table->bool('sel_ice');
            $table->bool('sel_gas');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mining_tax_settings');
    }
}