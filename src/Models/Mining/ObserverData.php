<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Models\Mining;


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

    public function get_moon_ore_group()
    {
        if ($this->group = 1884)
            $result = "<span class=\"badge badge-secondary\">R4</span>";
        elseif($this->group == 1920)
            $result = "<span class=\"badge badge-info\">R8</span>";
        elseif($this->group == 1921)
            $result = "<span class=\"badge badge-success\">R16</span>";
        elseif($this->group == 1921)
            $result = "<span class=\"badge badge-warning\">R32</span>";
        elseif($this->group == 1922)
            $result = "<span class=\"badge badge-danger\">R8</span>";
        else $result = "UNK";
        return $result;
    }
}