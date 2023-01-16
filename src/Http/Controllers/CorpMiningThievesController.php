<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Http\Controllers;

use Seat\Web\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CorpMiningThievesController extends Controller
{
    private $illegalCharacterMining;

    public function getData()
    {
        $data = DB::table('corporation_industry_mining_observer_data')
            ->select(
                'corporation_id AS id',
                'observer_id',
                'character_id',
                'recorded_corporation_id',
                'quantity',
                'created_at'
            )
            ->join('corporation_industry_mining_observers AS cobs', 'cobs.observer_id', 'cobs.corporation_id')
            ->join('character_infos AS ci', 'ci.character_id', 'ci.name')
            ->where('observer_id', '=', 'cobs.observer_id')
            ->where('recorded_corporation_id', '!=', '98496411')
            ->get();
        return view('corpmoonmining::corpmoonmining', [
            'data' => $data
        ]);
    }
}