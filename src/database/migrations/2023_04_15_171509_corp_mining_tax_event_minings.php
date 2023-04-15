<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Seat\Services\Models\Schedule;

class CorpMiningTaxEventMinings extends Migration
{
    public function up()
    {
        Schema::create('corp_mining_tax_event_minings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('character_name');
            $table->integer('event_id');
            $table->integer('type_id');
            $table->integer('quantity');
            $table->integer('refined_price');
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
        Schema::dropIfExists('corp_mining_tax_event_minings');
    }
}