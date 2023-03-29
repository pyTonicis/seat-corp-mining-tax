<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Models\Mining;

class CorporationMoonMining
{
    public $observers = [];

    public function add_observer(ObserverData $observerData): void
    {
        if(!$this->has_observer($observerData->observer_id))
        $this->observers[$observerData->observer_id] = $observerData;
    }

    public function has_observer(int $observer_id): bool
    {
        return array_key_exists($observer_id, $this->observers);
    }
}