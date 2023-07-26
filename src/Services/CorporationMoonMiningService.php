<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Services;

use pyTonicis\Seat\SeatCorpMiningTax\Helpers\CharacterHelper;
use pyTonicis\Seat\SeatCorpMiningTax\Models\Mining\CorporationMoonMining;
use pyTonicis\Seat\SeatCorpMiningTax\Models\TaxData\OreType;
use Illuminate\Support\Facades\DB;
class CorporationMoonMiningService
{
    private function getMiningResultsFromDb(int $month, int $year)
    {

        return DB::table('corporation_industry_mining_observer_data as obs')
            ->select(
                'obs.corporation_id',
                'obs.observer_id',
                'obs.character_id',
                'obs.type_id',
                'obs.quantity',
                'obs.created_at'
            )
            ->where('obs.created_at', '=', '2022-12')
            ->get();
    }

    public function CreateCorpMiningResult($corpid) : CorporationMoonMining
    {
        $corpminingresult = new CorporationMoonMining();

        foreach ($this->getMiningResultsFromDb(12, 2022) as $data) {

        }
        return $corpminingresult;
    }
}