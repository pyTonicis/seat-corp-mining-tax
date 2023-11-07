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

class UpdateContracts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $contractService;

    private $settingService;

    private $force;

    public function __construct($force)
    {
        $this->force = $force;
        $this->settingService = new SettingService();
        $this->contractService = new Contracts();
    }

    public function tags()
    {
        return ["seat-corp-mining-tax", "tax:contracts",];
    }

    public function handle()
    {
        $this->contractService->setContractIds($this->settingService->getValue('corporation_id'));
        $this->contractService->updateContractStatus($this->settingService->getValue('corporation_id'));
    }

}