<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use pyTonicis\Seat\SeatCorpMiningTax\Services\Contracts;
use pyTonicis\Seat\SeatCorpMiningTax\Services\SettingService;
class CreateContracts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $month;
    private $year;

    private $force;

    private $contractService;

    private $settingService;

    public function __construct($force, $year, $month)
    {
        $this->force = $force;
        $this->month = $month;
        $this->year = $year;
        $this->settingService = new SettingService();
        $this->contractService = new Contracts();
    }

    public function tags()
    {
        return ["seat-corp-mining-tax", "tax:generator",];
    }

    public function handle()
    {
        $settings = $this->settingService->getAll();
        $this->contractService->createTaxContracts($settings['corporation_id'], $this->month, $this->year);
    }
}