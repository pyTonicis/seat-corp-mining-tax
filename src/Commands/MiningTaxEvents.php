<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Commands;

use Illuminate\Console\Command;
use pyTonicis\Seat\SeatCorpMiningTax\Jobs\UpdateEvents;

class MiningTaxEvents extends Command
{
    protected $signature = 'tax:events {--F|force} {--N|now}';

    protected $description = 'This job checks hourly the event status and fetch event mining data';

    public function handle()
    {
        if($this->option('now')){
            UpdateEvents::dispatchSync($this->option('force'));
        } else {
            UpdateEvents::dispatch($this->option('force'));
        }
    }

}