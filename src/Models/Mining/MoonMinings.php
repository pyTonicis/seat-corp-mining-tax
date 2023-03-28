<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Models\Mining;

class MoonMinings
{
    public $observers = [];

    public function add_observer(MoonMiningData $moonMiningData) {
        $this->observers[$moonMiningData->observer_id] = $moonMiningData;
    }

}