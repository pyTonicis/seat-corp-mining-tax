<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Services;

use pyTonicis\Seat\SeatCorpMiningTax\Helpers\CharacterHelper;
use pyTonicis\Seat\SeatCorpMiningTax\Helpers\EvePraisalHelper;
use pyTonicis\Seat\SeatCorpMiningTax\Models\Mining\ThievesResult;
use pyTonicis\Seat\SeatCorpMiningTax\Models\TaxData\CharacterData;
use pyTonicis\Seat\SeatCorpMiningTax\Models\TaxData\CharacterMiningRecord;
use pyTonicis\Seat\SeatCorpMiningTax\Models\TaxData\MiningTaxResult;
use pyTonicis\Seat\SeatCorpMiningTax\Models\TaxData\OreType;
use Illuminate\Support\Facades\DB;

class ThievesService
{
    private function getMiningResultFromDb(int $corp_id)
    {
        return DB::table('corporation_industry_mining_observer_data')
            ->select(
                'corporation_id',
                'observer_id',
                'character_id',
                'recorded_corporation_id',
                'created_at'
            )
            ->where('recorded_corporation_id', '!=', $corp_id)
            ->get();
    }

    public function createIllegalMiningResult(int $corpID) : ThievesResult
    {
        $result = new ThievesResult();

        foreach ($this->getMiningResultFromDb($corpID) as $data) {
            $result->character_id = $data->character_id;
            $result->date = date("y-m-d H:i", strtotime($data->created_at));
            $result->character_name = CharacterHelper::getCharacterName($data->character_id);
            $result->corporation_id = $data->corporation_id;
            $result->observer_id = $data->observer_id;
        }
        return $result;
    }
}