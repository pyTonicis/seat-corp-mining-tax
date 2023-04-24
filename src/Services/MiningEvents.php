<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Services;

use DateTime;
use pyTonicis\Seat\SeatCorpMiningTax\Helpers\CharacterHelper;
use pyTonicis\Seat\SeatCorpMiningTax\Models\Mining\CharacterMinings;
use pyTonicis\Seat\SeatCorpMiningTax\Models\Mining\MiningGroups;
use Seat\Web\Http\Controllers\Controller;
use Seat\Eveapi\Models\Character\CharacterInfo;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js;
use Datatables;

class MiningEvents
{
    public function controlEventStatus()
    {
        $events = DB::table('corp_mining_tax_events')
            ->get();
    }
}