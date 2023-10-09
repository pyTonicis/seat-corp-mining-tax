<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Commands;

use Illuminate\Console\Command;
use pyTonicis\Seat\SeatCorpMiningTax\Jobs\UpdateMiningEvents;

class MiningTaxEvents extends Command
{
    protected $signature = 'tax:event_update {--F|force} {--N|now}  {year?} {month?}';

    protected $description = 'This updates the events every 5 minutes';

    public function handle()
    {
        $year = date('Y', time());
        $month = date('n', time());

        if (($this->argument('month')) && ($this->argument('year'))) {
            $year = $this->argument('year');
            $month = $this->argument('month');
        }

        if($this->option('now')){
            UpdateMiningEvents::dispatchNow($this->option('force'), $year, $month);
        } else {
            UpdateMiningEvents::dispatch($this->option('force'), $year, $month);
        }
    }
}