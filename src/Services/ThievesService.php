<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Services;

use pyTonicis\Seat\SeatCorpMiningTax\Helpers\CharacterHelper;
use pyTonicis\Seat\SeatCorpMiningTax\Models\Mining\ThievesResult;
use Illuminate\Support\Facades\DB;

class ThievesService
{
    private function getMiningResultFromDb(int $corp_id)
    {
        return DB::table('corporation_industry_mining_observer_data as a')
            ->select(
                'a.corporation_id',
                'a.observer_id',
                'a.character_id',
                'a.recorded_corporation_id',
                'a.created_at',
                's.name'
            )
            ->where('recorded_corporation_id', '!=', $corp_id)
            ->LeftJoin('universe_structures as s', 'a.observer_id', '=', 's.structure_id')
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
            $result->observer_name = $data->name;
        }
        return $result;
    }
}