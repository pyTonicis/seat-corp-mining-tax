<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Services;

use Illuminate\Support\Facades\DB;

class SettingService
{
    private $_settings;

    public function __construct()
    {
        $this->getSettingsFromDb();
    }

    private function getSettingsFromDb() : void
    {
        $settings = DB::table('corp_mining_tax_settings')
            ->get();
        foreach($settings as $item)
        {
            $this->_settings[$item->name] = $item->value;
        }
    }

    public function getValue(string $key)
    {
        return $this->_settings[$key];
    }

    public function setValue(string $key, $value)
    {
        if ($value == 'on') {
            $value = 'true';
        }
        elseif ($value == 'off') {
            $value = 'false';
        }
        DB::table('corp_mining_tax_settings')
            ->where('name', $key)
            ->update(['value' => $value]);
    }

    public function setAll(array $newSettings) : void
    {
        if (count($newSettings) <= 0)
        {
            return;
        }

        foreach($newSettings as $key => $value)
        {
            $this->setValue($key, $value);
        }
    }

    public function getAll() : array
    {
        return $this->_settings;
    }
}