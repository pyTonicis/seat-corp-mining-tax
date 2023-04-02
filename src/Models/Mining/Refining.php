<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Models\Mining;

class Refining
{
    public $refiningData = [];

    public function has_material_record(Array $materials) {
        $keys = [];
        foreach($materials as $key => $value)
            array_push($keys, $key);
        return array_key_exists($this->refiningData, $keys);
    }

    public function add_materials(Array $materials) {
        if(!$this->has_material_record($materials)) {
            $record = new Material;
        }
    }
}