<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CorpMiningTaxAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('corp_mining_tax', function (Blueprint $table) {
            $table->integer('character_id')->after('main_character_id');
        });
    }

    public function down(): void {}
}