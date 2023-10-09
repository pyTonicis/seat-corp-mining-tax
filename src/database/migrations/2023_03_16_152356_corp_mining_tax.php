<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Seat\Services\Models\Schedule;

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
            $table->biginteger('event_tax');
            $table->integer('status');
            $table->biginteger('contractId');
            $table->timestamps();
        });


        /*
         * Install Cron Job for tax update
         */
        $schedule = new Schedule();
        $schedule->command = "tax:update";
        $schedule->expression = "0 * * * *";
        $schedule->allow_overlap = false;
        $schedule->allow_maintenance = false;
        $schedule->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('corp_mining_tax');
    }
}
