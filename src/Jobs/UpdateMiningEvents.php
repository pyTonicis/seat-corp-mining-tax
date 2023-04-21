<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use pyTonicis\Seat\SeatCorpMiningTax\Services\SettingService;

class UpdateMiningEvents implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $month;
    private $year;

    private $force;

    private $miningTaxService;

    private $settingService;

    public function __construct($force, $year, $month)
    {
        $this->force = $force;
        $this->month = $month;
        $this->year = $year;
        $this->miningTaxService = new MiningTaxService();
        $this->settingService = new SettingService();
    }

    public function tags()
    {
        return ["seat-corp-mining-tax", "tax:event_update",];
    }

    public function handle()
    {
        $settings = $this->settingService->getAll();
    }
}