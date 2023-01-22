<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Http\Controllers;

use Seat\Web\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CorpMiningTaxSettingController extends Controller
{
    public function getSettings() {
        return view('corpminingtax::corpminingsettings');
    }
}