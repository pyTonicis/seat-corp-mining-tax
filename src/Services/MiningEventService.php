<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Services;


use pyTonicis\Seat\SeatCorpMiningTax\Helpers\CharacterHelper;
use pyTonicis\Seat\SeatCorpMiningTax\Helpers\EveJaniceHelper;
use pyTonicis\Seat\SeatCorpMiningTax\Helpers\EveMarketHelper;
use pyTonicis\Seat\SeatCorpMiningTax\Models\Mining\EventMining;
use pyTonicis\Seat\SeatCorpMiningTax\Models\TaxData\CharacterData;
use pyTonicis\Seat\SeatCorpMiningTax\Models\TaxData\CharacterMiningRecord;
use Seat\Web\Http\Controllers\Controller;
use Seat\Eveapi\Models\Character\CharacterInfo;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js;

class MiningEventService
{

    public function updateEventStatus()
    {
        $data = DB::table('corp_mining_tax_events')
            ->select('*')
            ->get();
        if(!empty($data)) {
            $status = DB::update(DB::raw("update corp_mining_tax_events set event_status=2 where event_start <= date(now()) and event_stop >= date(now())"));
            $status = DB::update(DB::raw("update corp_mining_tax_events set event_status=3 where event_stop < date(now())"));
        }
    }

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

    public function updateEventMiningLedger(int $event)
    {
        $settingsService = new SettingService();
        $settings = $settingsService->getAll();
        $data = DB::table('corp_mining_tax_events')
            ->first();
        $minings = DB::table('character_minings')
            ->selectRaw('character_id, sum(quantity) as quantity, type_id')
            ->groupBy('type_id')
            ->whereBetween('created_at', [$data->event_start, $data->event_stop])
            ->get();
        foreach($minings as $mining) {
            $refined_price = 0;
            foreach (Reprocessing::ReprocessOreByTypeId($mining->type_id, $mining->quantity, (float)($settings['ore_refining_rate'] / 100)) as $key => $value) {

                if ($settings['ore_valuation_price'] == 'Ore Price') {
                    if ($settings['price_provider'] == 'Eve Market')
                        $price = EveMarketHelper::getItemPriceById($mining->type_id) * $mining->quantity;
                    else
                        $price = EveJaniceHelper::getItemPriceByTypeId($mining->type_id) * $mining->quantity;
                } else {
                    if ($settings['price_provider'] == 'Eve Market')
                        $price = EveMarketHelper::getItemPriceById($key) * $value;
                    else
                        $price = EveJaniceHelper::getItemPriceByTypeId($key) * $value;
                }
                $tax_rate = $this->getEventMiningTaxRate($mining->event_id);
                $refined_price += $price * ($tax_rate/100);
            }
            DB::table('corp_mining_tax_event_minings')
                ->updateOrInsert(['character_name' => CharacterHelper::getCharacterName($mining->character_id), 'event_id' => $data->event_id, 'type_id' => $mining->type_id],
        ['quantity' => $mining->quantity, 'refined_price' => $refined_price]);
        }
    }
}