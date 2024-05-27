<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use pyTonicis\Seat\SeatCorpMiningTax\Services\Contracts;
use pyTonicis\Seat\SeatCorpMiningTax\Services\MiningEventService;
use pyTonicis\Seat\SeatCorpMiningTax\Services\SettingService;

class UpdateEvents implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $month;
    private $year;
    private $force;
    private $contractService;

    private $settingService;

    private $eventService;

    public function __construct($force)
    {
        $this->force = $force;
        $this->settingService = new SettingService();
        $this->contractService = new Contracts();
        $this->eventService = new MiningEventService();
    }

    public function tags()
    {
        return ["seat-corp-mining-tax", "tax:events",];
    }

    public function handle()
    {
        $settings = $this->settingService->getAll();
        $this->eventService->updateEventStatus();
    }
}