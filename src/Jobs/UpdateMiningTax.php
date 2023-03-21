<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use pyTonicis\Seat\SeatCorpMiningTax\Services\MiningTaxService;
use pyTonicis\Seat\SeatCorpMiningTax\Services\SettingService;

class UpdateMiningTax implements ShouldQueue
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
        return ["seat-corp-mining-tax", "tax:update",];
    }

    public function handle()
    {
        //TODO Update database
        $settings = $this->settingService->getAll();
        $data = $this->miningTaxService->createMiningTaxResult((int)$settings['corporation_id'], (int)$this->month, (int)$this->year);
        foreach($data->characterData as $character)
        {
            DB::table('corp_mining_tax')
                ->updateOrInsert(['main_character_id' => $character->main_character_id, 'year' => $this->year, 'month' => $this->month],
                ['quantity' => $character->priceSummary, 'volume' => $character->volume, 'price' => $character->tax3]
                );
        }
    }
}