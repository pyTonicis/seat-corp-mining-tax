<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\database\migrations;

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
            $table->biginteger('main_character_id');
            $table->biginteger('contractId')->primary();
            $table->biginteger('contractIssuer');
            $table->string('contractTitle');
            $table->text('contractData');
            $table->enum('contractStatus');
            $table->integer('month');
            $table->integer('year');
            $table->string('title');
            $table->biginteger('tax');
            $table->timestamps();
        });
    }
}