<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CorpMiningTaxEventsAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('corp_mining_tax_events', function (Blueprint $table) {
            $table->string('event_tracker')->after('event_status');
        });
    }

    public function down(): void
    {
    }
}