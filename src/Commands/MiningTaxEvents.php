<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Commands;

use Illuminate\Console\Command;

class MiningTaxEvents extends Command
{
    protected $signature = 'tax:events {--F|force} {--N|now}';

    protected $description = 'This job checks hourly the event status and fetch event mining data';

    public function handle()
    {

    }

}