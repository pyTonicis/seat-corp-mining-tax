<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeEventMiningsPrice extends Migration
{
    /**
     * Change Column refined_price type to bigint
     *
     * @return void
     */
    public function up()
    {
        Schema::table('corp_mining_tax_event_minings', function (Blueprint $table) {
            $table->bigInteger('refined_price')->change();
        });
    }

    public function down(): void {}
}