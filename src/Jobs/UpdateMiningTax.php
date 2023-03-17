<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use pyTonicis\Seat\SeatCorpMiningTax\Services\MiningTaxService;

class UpdateMiningTax implements ShouldQueue
{
    private $month;
    private $year;

    private $miningTaxService;

    public function __construct($force, $year, $month)
    {
        $this->month = $month;
        $this->year = $year;
        $this->miningTaxService = new MiningTaxService(19399254, $month, $year);
    }

    public function handle()
    {
        //TODO Update database
        $data = $this->miningTaxService->createMiningTaxResult(1939595452, $this->month, $this->year);
    }
}