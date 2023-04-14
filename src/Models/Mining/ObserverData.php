<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Models\Mining;


use pyTonicis\Seat\SeatCorpMiningTax\Services\Reprocessing;
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
        $sum = 0;
        foreach ($this->minings as $mining) {
            foreach($mining->ore_types as $name => $quantity) {
                $materials = Reprocessing::ReprocessOreByTypeId(Reprocessing::getItemIdByName($name), $quantity);
                foreach($materials as $mid => $mq) {
                    $price = $this->getItemPriceById($mid) * $mq;
                    $sum += $price;
                }
            }
        }
        return $sum;
    }

    public function get_moon_ore_group()
    {
        if ($this->group == 1884)
            $result = " badge-secondary\">R4";
        elseif($this->group == 1920)
            $result = " badge-info\">R8";
        elseif($this->group == 1921)
            $result = " badge-success\">R16";
        elseif($this->group == 1921)
            $result = " badge-warning\">R32";
        elseif($this->group == 1922)
            $result = " badge-danger\">R8";
        else $result = "UNK";
        return $result;
    }

    private function getItemPriceById(int $id) :int
    {
        $data = DB::table('market_prices')
            ->select('average_price')
            ->where('type_id', '=', $id)
            ->first();
        return $data->average_price;
    }
}