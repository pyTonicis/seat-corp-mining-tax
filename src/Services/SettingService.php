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
        if (!array_key_exists('taxes_moon', $newSettings)) {
            $newSettings['taxes_moon'] = 'false';
         }
        if (!array_key_exists('taxes_corp_moon', $newSettings)) {
            $newSettings['taxes_corp_moon'] = 'false';
        }
        if (!array_key_exists('taxes_ore', $newSettings)) {
            $newSettings['taxes_ore'] = 'false';
        }
        if (!array_key_exists('taxes_ice', $newSettings)) {
            $newSettings['taxes_ice'] = 'false';
        }
        if (!array_key_exists('taxes_gas', $newSettings)) {
            $newSettings['taxes_gas'] = 'false';
        }
        if (!array_key_exists('taxes_abyssal', $newSettings)) {
            $newSettings['taxes_abyssal'] = 'false';
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