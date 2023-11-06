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
            $table->integer('corporation_id');
            $table->integer('month');
            $table->integer('year');
            $table->biginteger('quantity');
            $table->biginteger('volume');
            $table->biginteger('price');
            $table->biginteger('tax');
            $table->biginteger('event_tax');
            $table->integer('status');
            $table->timestamps();
        });


        /*
         * Install Cron Job for tax update every hour
         */
        $tax_update = new Schedule();
        $tax_update->command = "tax:update";
        $tax_update->expression = "2 * * * *";
        $tax_update->allow_overlap = false;
        $tax_update->allow_maintenance = false;
        $tax_update->save();

        /*
         * Install Cron Job to create tax contracts every month at 2.nd day
         */
        $tax_contracts = new Schedule();
        $tax_contracts->command = "tax:generator";
        $tax_contracts->expression = "1 1 2 * *";
        $tax_contracts->allow_overlap = false;
        $tax_contracts->allow_maintenance = false;
        $tax_contracts->save();

        /*
         * Install Cron Job for contract status update every hour
         */
        $tax_contracts = new Schedule();
        $tax_contracts->command = "tax:contracts";
        $tax_contracts->expression = "2 * * * *";
        $tax_contracts->allow_overlap = false;
        $tax_contracts->allow_maintenance = false;
        $tax_contracts->save();
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
