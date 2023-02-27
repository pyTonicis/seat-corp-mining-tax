<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Http\Controllers;

use Seat\Web\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js;

class CorpMiningMoonMinings extends Controller
{
    private $MoonObservers;
    private $extractions = [];

    public function getCorpObservers(Request $request)
    {
        $data = DB::table('corporation_industry_mining_observers')
            ->select(
                'observer_id',
                'name'
            )
            ->LeftJoin('universe_structures', 'corperation_industry_mining_observers.observer_id', '=', 'universe_structures.structure_id')
            ->where('corporation_id', '=', '98496411')
            ->get();
        return view('corpmoonmining::corpmoonmining', ['data' => $data]);
    }

    public function getCorpMoonExtractions(int $id)
    {
        $data = DB::table('corporation_industry_mining_observer_data')
            ->select(
                'last_updated'
            )
            ->selectRAW("sum(quantity) as quantity")
            ->groupby('last_updated')
            ->where('observer_id', $id)
            ->get();
        return $data;
    }
}