<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Commands;

use Illuminate\Console\Command;
use pyTonicis\Seat\SeatCorpMiningTax\Jobs\UpdateMiningTax;

class MiningTaxGenerator extends Command
{
    protected $signature = 'tax:generator {--F|force} {--N|now}  {year?} {month?}';

    protected $description = 'This create monthly mining tax contracts';

    public function handle()
    {
        $year = date('Y', strtotime("-1 month", time()));
        $month = date('n', strtotime("-1 month", time()));

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