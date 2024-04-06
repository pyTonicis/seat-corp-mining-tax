<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Commands;

use Illuminate\Console\Command;
use pyTonicis\Seat\SeatCorpMiningTax\Jobs\UpdateMiningTax;

class MiningTaxUpdate extends Command
{
    protected $signature = 'tax:update {--F|force} {--N|now}  {year?} {month?}';

    protected $description = 'This job updates the tax of the current month. Update tax every hour';

    public function handle()
    {
        $year = date('Y', time());
        $month = date('n', time());

        if (($this->argument('month')) && ($this->argument('year'))) {
            $year = $this->argument('year');
            $month = $this->argument('month');
        }

        if($this->option('now')){
            UpdateMiningTax::dispatchNow($this->option('force'), $year, $month);
        } else {
            UpdateMiningTax::dispatch($this->option('force'), $year, $month);
        }
    }
}