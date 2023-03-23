<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Models\Mining;

class CharacterMinings
{
    public $character_id;

    public $mined_total_quantity;

    public $mined_total_volume;

    public $mined_total_price;

    public $labels = [];

    public $quantity_per_month = [];

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
}