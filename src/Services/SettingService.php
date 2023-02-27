<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Services;

use Illuminate\Support\Facades\DB;

class SettingService
{
    private $_settings;

    private function getSettingsFromDb()
    {
        $settings = DB::table('mining_tax_settings')
            ->get();
        foreach($settings as $item)
        {
            $this->_settings[$item->name] = $item->value;
        }
    }

    public function loadSettings(): array
    {
        return $this->_settings;
    }

    public function getValue(string $key)
    {
        return $this->_settings[$key];
    }
}