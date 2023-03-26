<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Models\Mining;

class CharacterMinings
{
    public $character_id;

    public $mined_total_quantity;

    public $mined_total_volume;

    public $mined_total_price;

    public $labels = [];

    public $volume_per_month = [];

    public $quantity_per_group = [];

    public function add_quantity(int $quantity) :void
    {
        $this->mined_total_quantity += $quantity;
    }

    public function add_volume(int $volume) :void
    {
        $this->mined_total_volume += $volume;
    }

    public function add_price(int $price) :void
    {
        $this->mined_total_price += $price;
    }

    public function add_quantity_group(string $group, int $value, int $date) :void
    {
        if (!array_key_exists($date, $this->quantity_per_group)) {
            $this->quantity_per_group[$date][$group] = $value;
        } else {
            if (!array_key_exists($group, $this->quantity_per_group[$date])) {
                $this->quantity_per_group[$date][$group] = $value;
            } else {
                array_push($this->quantity_per_group[$date][$group], $value);
            }
        }
    }

}