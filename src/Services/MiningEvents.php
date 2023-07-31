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

    private function getEventMinings(int $event_id)
    {
        return DB::table('corp_mining_tax_event_minings')
            ->where('event_id', '=', $event_id)
            ->get();
    }

    public function createEventMiningTax(int $month, int $year): EventMining
    {
        $minings = new EventMining($month, $year);
        $events = $this->getEvents($month, $year);
        if (!is_null($events))
        {
            foreach($events as $event)
            {
                foreach($this->getEventMinings($event->id) as $mining)
                {
                    $mainCharacterData = CharacterHelper::getMainCharacterCharacter(CharacterHelper::getCharacterIdByName($mining->character_name));

                    if (!$minings->hasCharacterData($mainCharacterData->main_character_id)) {

                        $charData = new CharacterData(
                            $mainCharacterData->main_character_id,
                            $mainCharacterData->name
                        );

                        $minings->addCharacterData($charData);
                    } else {
                        $charData = $minings->getCharacterDataById($mainCharacterData->main_character_id);
                    }

                    $charData->addCharacterMining(new CharacterMiningRecord(
                        $mining->type_id,
                        $mining->quantity
                    ));
                }
            }
            //TODO: compare character Mining with event Mining

            //TODO: remove EventTax from Mining Result Tax (inside MiningTaxService)
        }
        return $minings;
    }
}