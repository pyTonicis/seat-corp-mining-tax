<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Commands;

use Illuminate\Console\Command;
use pyTonicis\Seat\SeatCorpMiningTax\Jobs\UpdateContracts;

class MiningTaxContracts extends Command
{
    protected $signature = 'tax:contracts {--F|force} {--N|now}';

    protected $description = 'This job checks hourly the contracts status';

    public function handle()
    {
        if($this->option('now')){
            UpdateContracts::dispatchSync($this->option('force'));
        } else {
            UpdateContracts::dispatch($this->option('force'));
        }
    }
}