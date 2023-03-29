<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Models\Mining;

class MoonMinings
{
    public $date;

    public $ore_types = [];

    public $quantity;

    public $volume;

    public $scanned_volume;

    public function add_ore_type(string $ore_name, int $quantity) {
        if(!array_key_exists($ore_name, $this->ore_types)) {
            $this->ore_types[$ore_name] = $quantity;
            $this->quantity = $quantity;
        } else {
            $this->ore_types[$ore_name] += $quantity;
            $this->quantity += $quantity;
        }
    }

}