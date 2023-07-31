<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Models\Mining;

use pyTonicis\Seat\SeatCorpMiningTax\Models\TaxData\CharacterData;

class EventMining
{
    public $month;

    Public $year;
    public $characterData = [];

    public function __construct(int $month, int $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function hasCharacterData(int $characterId): bool
    {
        return array_key_exists($characterId, $this->characterData);
    }

    public function addCharacterData(CharacterData $characterData): void
    {
        if(!$this->hasCharacterData($characterData->characterId)) {
            $this->characterData[$characterData->characterId] = $characterData;
        }
    }

    public function getCharacterDataById(int $characterId): ?CharacterData
    {

        if (!$this->hasCharacterData($characterId)) {
            return null;
        }

        return $this->characterData[$characterId];
    }
}