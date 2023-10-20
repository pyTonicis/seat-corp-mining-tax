<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Seat\Services\Models\Schedule;

class CorpMiningTaxEvents extends Migration
{
    public function up()
    {
        Schema::create('corp_mining_tax_events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('event_name');
            $table->datetime('event_start');
            $table->datetime('event_stop');
            $table->integer('event_duration');
            $table->integer('event_tax');
            $table->string('event_valuation');
            $table->integer('event_status');
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
        Schema::dropIfExists('corp_mining_tax_events');
    }
}