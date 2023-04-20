<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Models\Mining;

use pyTonicis\Seat\SeatCorpMiningTax\Helpers\EveMarketHelper;
use pyTonicis\Seat\SeatCorpMiningTax\Services\Reprocessing;

class MoonMinings
{
    public $date;

    public $ore_types = [];

    public $quantity = 0;

    public $volume;

    private $names;
    public $scanned_volume;

    public function add_ore_type(string $ore_name, int $quantity) {
        if(!array_key_exists($ore_name, $this->ore_types)) {
            $this->ore_types[$ore_name] = $quantity;
            $this->quantity += $quantity;
        } else {
            $this->ore_types[$ore_name] += $quantity;
            $this->quantity += $quantity;
        }
    }

    public function get_ore_types() {

        foreach ($this->ore_types as $n => $q) {
            $this->names .= $n . " x" . $q . " ,";
        }
        return $this->names;
    }

    public function get_mined_isk() {
        $sum = 0;
        foreach ($this->ore_types as $o_typeName => $o_quantity) {
            $materials = Reprocessing::ReprocessOreByTypeId(Reprocessing::getItemIdByName($o_typeName), $o_quantity);
            foreach ($materials as $mid => $mq) {
                $price = EveMarketHelper::getItemPriceById($mid) * $mq;
                $sum += $price;
            }
        }
        return $sum;
    }

}