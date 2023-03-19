<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CorpMiningTaxSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corp_mining_tax_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('value');
            $table->timestamps();
        });
        $this->init();
    }

    /**
     * Initalize settings table
     *
     * @return void
     */
    private function init() : void
    {
        DB::table('corp_mining_tax_settings')
            ->insert(['name' => 'corporation_id', 'value' => '98711234']);
        DB::table('corp_mining_tax_settings')
            ->insert(['name' => 'corporation_name', 'value' => 'WipeOut Inc. - Holding']);
        DB::table('corp_mining_tax_settings')
            ->insert(['name' => 'ore_refining_rate', 'value' => '90']);
        DB::table('corp_mining_tax_settings')
            ->insert(['name' => 'ore_valuation_price', 'value' => 'Ore Price']);
        DB::table('corp_mining_tax_settings')
            ->insert(['name' => 'price_provider', 'value' => 'Eve Market']);
        DB::table('corp_mining_tax_settings')
            ->insert(['name' => 'price_modifier', 'value' => '100']);
        DB::table('corp_mining_tax_settings')
            ->insert(['name' => 'contract_issuer', 'value' => 'Dollar Boy']);
        DB::table('corp_mining_tax_settings')
            ->insert(['name' => 'contract_expire', 'value' => '7']);
        DB::table('corp_mining_tax_settings')
            ->insert(['name' => 'r64_rate', 'value' => '15']);
        DB::table('corp_mining_tax_settings')
            ->insert(['name' => 'r32_rate', 'value' => '10']);
        DB::table('corp_mining_tax_settings')
            ->insert(['name' => 'r16_rate', 'value' => '10']);
        DB::table('corp_mining_tax_settings')
            ->insert(['name' => 'r8_rate', 'value' => '10']);
        DB::table('corp_mining_tax_settings')
            ->insert(['name' => 'r4_rate', 'value' => '10']);
        DB::table('corp_mining_tax_settings')
            ->insert(['name' => 'ice_rate', 'value' => '10']);
        DB::table('corp_mining_tax_settings')
            ->insert(['name' => 'gas_rate', 'value' => '10']);
        DB::table('corp_mining_tax_settings')
            ->insert(['name' => 'abyssal_rate', 'value' => '5']);
        DB::table('corp_mining_tax_settings')
            ->insert(['name' => 'taxes_moon', 'value' => '1']);
        DB::table('corp_mining_tax_settings')
            ->insert(['name' => 'taxes_corp_moon', 'value' => '1']);
        DB::table('corp_mining_tax_settings')
            ->insert(['name' => 'taxes_ore', 'value' => '1']);
        DB::table('corp_mining_tax_settings')
            ->insert(['name' => 'taxes_ice', 'value' => '1']);
        DB::table('corp_mining_tax_settings')
            ->insert(['name' => 'taxes_gas', 'value' => '1']);
        DB::table('corp_mining_tax_settings')
            ->insert(['name' => 'taxes_abyssal', 'value' => '0']);
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
