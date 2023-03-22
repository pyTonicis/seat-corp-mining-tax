<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CorpMiningTax extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corp_mining_tax', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('main_character_id');
            $table->integer('month');
            $table->integer('year');
            $table->biginteger('quantity');
            $table->biginteger('volume');
            $table->biginteger('price');
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
        //
    }
}
