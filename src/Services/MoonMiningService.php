<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Services;

class MoonMiningService
{

    private function getCorpMoonMiningObservers(int $corp_id)
    {
        $data = DB::table('corporation_industry_mining_observers as o')
            ->select(
                'o.observer_id',
                'u.name',
                's.name as systemName'
            )
            ->join('universe_structures as u', 'o.observer_id', '=', 'u.structure_id')
            ->join('solar_systems as s', 'u.solar_system_id', '=', 's.system_id')
            ->where('o.corporation_id', '=', $corp_id)
            ->orderBy('s.name', 'desc')
            ->get();
        return $data;
    }

    private function getCorpMoonMiningData(int $corp_id)
    {
        $act_date = date("Y-m-01 - 00:00:00", strtotime("-3 months", time()));
        $data = DB::table('corporation_industry_mining_observer_data as a')
            ->select(
                'a.last_updated',
                'a.character_id',
                'a.observer_id',
                'a.type_id',
                'a.quantity',
                't.typeName',
                'u.name'
            )
            ->join('universe_structures as u', 'a.observer_id', '=', 'u.structure_id')
            ->join('invTypes as t', 'a.type_id', '=', 't.typeID')
            ->where('a.last_updated', '>=', $act_date)
            ->where('a.corporation_id', '=', $corp_id)
            ->orderBy('a.last_updated', 'desc')
            ->get();
        return $data;
    }

    public function getCorpMoonMinings()
    {
        $fetchItems = 0;
    }
}