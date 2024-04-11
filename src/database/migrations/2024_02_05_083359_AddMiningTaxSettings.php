<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMiningTaxSettings extends Migration
{

    /**
     * Add value to settings table
     *
     * @return void
     */
    public function up()
    {
        DB::table('corp_mining_tax_settings')
            ->insert(['name' => 'mining_tax_calculation', 'value' => 'combined']); // accumulated, individual
    }

    public function down(): void {}
}