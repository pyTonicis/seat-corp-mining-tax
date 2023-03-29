<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Models\Mining;


class ObserverData
{
    public $observer_id;

    public $observer_name;

    public $system_name;

    public $minings = [];

    public $group;

    public $total_mined_quantity;

    public function add_mining_record(MoonMinings $moonMining): void
    {
        if(!$this->has_mining_record($moonMining->date))
            $this->minings[$moonMining->date] = $moonMining;
    }

    public function has_mining_record($date): bool
    {
        return array_key_exists($date, $this->minings);
    }

    public function get_total_quantity(): int
    {
        $quantity = 0;
        foreach ($this->minings as $mining) {
            $quantity += $mining->quantity;
        }
        return $quantity;
    }
}