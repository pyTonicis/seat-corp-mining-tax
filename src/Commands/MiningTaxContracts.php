<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Commands;

use Illuminate\Console\Command;

class MiningTaxContracts extends Command
{
    protected $signature = 'tax:contracts';

    protected $description = 'This job checks hourly the contracts status';

    public function handle()
    {
        UpdateContracts::dispatch();
    }
}