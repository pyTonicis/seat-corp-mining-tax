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
