<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use pyTonicis\Seat\SeatCorpMiningTax\Services\SettingService;
use Seat\Web\Http\Controllers\Controller;

class CorpMiningTaxSettingController extends Controller
{
    public $settingsService;

    public function __construct(SettingService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    public function getSettings()
    {
        $settings = $this->settingsService->getAll();
        return view('corpminingtax::corpminingsettings', ['settings' => $settings]);
        //return view('corpminingtax::corpminingsettings');
    }

    public function saveSettings(Request $request) {
        return view('corpminingtax::corpminingsettings');
    }
}