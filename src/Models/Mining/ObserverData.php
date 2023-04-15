<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Models\Mining;


use pyTonicis\Seat\SeatCorpMiningTax\Helpers\EveMarketHelper;
use pyTonicis\Seat\SeatCorpMiningTax\Services\Reprocessing;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js;

class ObserverData
{
    public $observer_id;

    public $observer_name;

    public $system_name;

    public $minings = [];

    public $group = 0;

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

    public function get_total_mined_isk(): int
    {
        if(Cache::has($this->observer_id)) {
            return Cache::get($this->observer_id);
        } else {
            $sum = 0;
            foreach ($this->minings as $mining) {
                foreach ($mining->ore_types as $name => $quantity) {
                    $materials = Reprocessing::ReprocessOreByTypeId(Reprocessing::getItemIdByName($name), $quantity);
                    foreach ($materials as $mid => $mq) {
                        $price = EveMarketHelper::getItemPriceById($mid) * $mq;
                        $sum += $price;
                    }
                }
            }
        }
        Cache::put($this->observer_id, $sum, 86400);
        return $sum;
    }
}