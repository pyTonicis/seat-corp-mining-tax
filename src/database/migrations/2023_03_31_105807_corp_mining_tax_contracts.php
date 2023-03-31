<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Seat\Services\Models\Schedule;

class CorpMiningTaxContracts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corp_mining_tax_contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->biginteger('character_id');
            $table->biginteger('contractId');
            $table->biginteger('contractIssuer');
            $table->string('contractTitle');
            $table->text('contractData');
            $table->integer('contractStatus');
            $table->integer('month');
            $table->integer('year');
            $table->string('title');
            $table->biginteger('tax');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('corp_mining_tax_contracts');
    }
}