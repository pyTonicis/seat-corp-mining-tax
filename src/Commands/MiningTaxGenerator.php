<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Commands;

use Illuminate\Console\Command;
use pyTonicis\Seat\SeatCorpMiningTax\Jobs\CreateContracts;

class MiningTaxGenerator extends Command
{
    protected $signature = 'tax:generator {--F|force} {--N|now}  {year?} {month?}';

    protected $description = 'This job creates the monthly mining tax contracts';

    public function handle()
    {
        $year = (int)date('Y', strtotime("-1 month", time()));
        $month = (int)date('n', strtotime("-1 month", time()));

        if (($this->argument('month')) && ($this->argument('year'))) {
            $year = $this->argument('year');
            $month = $this->argument('month');
        }

        if($this->option('now')){
            CreateContracts::dispatchSync($this->option('force'), $year, $month);
        } else {
            CreateContracts::dispatch($this->option('force'), $year, $month);
        }


    }
}