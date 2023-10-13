<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Services;


use pyTonicis\Seat\SeatCorpMiningTax\Helpers\CharacterHelper;
use pyTonicis\Seat\SeatCorpMiningTax\Models\Mining\EventMining;
use pyTonicis\Seat\SeatCorpMiningTax\Models\TaxData\CharacterData;
use pyTonicis\Seat\SeatCorpMiningTax\Models\TaxData\CharacterMiningRecord;
use Seat\Web\Http\Controllers\Controller;
use Seat\Eveapi\Models\Character\CharacterInfo;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js;

class MiningEvents
{

    public $characterData = [];
    private function getEvents(int $month, int $year)
    {
        return DB::table('corp_mining_tax_events')
            ->whereMonth('event_start', $month)
            ->whereYear('event_start', $year)
            ->get();
    }

    private function getEventMining(int $event_id)
    {
        return DB::table('corp_mining_tax_event_minings')
            ->where('event_id', '=', $event_id)
            ->get();
    }

    private function getEventMinings(array $event_ids)
    {
        return DB::table('corp_mining_tax_event_minings')
            ->whereIn('event_id', $event_ids)
            ->get();
    }

    public function createEventMiningTax(int $month, int $year)
    {
        $events = $this->getEvents($month, $year);
        $event_ids = array();
        if (!is_null($events))
        {
            foreach($events as $event) {
                array_push($event_ids, $event->id);
            }
            $miningResult = $this->getEventMinings($event_ids);
        }
        return $miningResult;
    }

    public function getEventMiningTaxRate(int $event) : int
    {
        $data = DB::table('corp_mining_tax_events')
            ->select('event_tax')
            ->where('id', '=', $event)
            ->first();
        return $data->event_tax;
    }
}