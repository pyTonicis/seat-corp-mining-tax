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

    public function get_total_mined_volume(int $observer_id): int
    {
        $total_mined_quantity = 0;
        if (array_key_exists($observer_id, $this->observers)) {
            $total_mined_quantity = $this->observers[$observer_id]->get_total_quantity();
        }
        return $total_mined_quantity * 10;
    }
}