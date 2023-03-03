<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Http\Controllers;

use pyTonicis\Seat\SeatCorpMiningTax\Models\TaxData\MiningTaxSettings;
use Seat\Web\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CorpMiningTaxSettingController extends Controller
{

    public function getSettings() {
        $settings = MiningTaxSettings::all();
        return view('corpminingtax::corpminingsettings', ['settings' => $settings]);
    }

    public function saveSettings(Request $request) {
        return view('corpminingtax::corpminingsettings');
    }
}