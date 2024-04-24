<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Http\Controllers;

use pyTonicis\Seat\SeatCorpMiningTax\Helpers\CharacterHelper;
use Seat\Web\Http\Controllers\Controller;
use Seat\Eveapi\Models\Character\CharacterInfo;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js;
use Datatables;

class CorpMiningLog extends Controller
{
    public function index()
    {
        $character = auth()->user()->main_character['character_id'];
        //$characters = CharacterHelper::getLinkedCharacters($character);
        $miningdata = DB::table('corp_mining_tax as cm')
            ->select('*')
            ->join('character_infos as ci', 'ci.character_id', 'cm.character_id')
            ->where('main_character_id', '=', $character)
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        return view('corpminingtax::corpmininglog', ['miningdata' => $miningdata]);
    }
}