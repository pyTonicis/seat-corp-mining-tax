<?php

/*
This file is part of SeAT

Copyright (C) 2015 to 2020  Leon Jacobs

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

namespace pyTonicis\Seat\SeatCorpMiningTax\Http\Controllers;

use pyTonicis\Seat\SeatCorpMiningTax\Helpers\CharacterHelper;
use Seat\Web\Http\Controllers\Controller;
use Seat\Eveapi\Models\Character\CharacterInfo;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js;
use Datatables;

class CorpMiningOverviewController extends Controller
{
    public function getHome(CharacterInfo $character)
    {
        $tmq = 0;
        $tmv = 0;
        $tmisk = 0;
        $character = auth()->user()->main_character['character_id'];
        $l = array();
        $datum_now = date('Y-m', time());

        for ($i = 0; $i < 12; $i++) {
            $m = "-" . $i . "month";
            $datum_now = strtotime($m);
            array_push($l, date('Y-m', (int)$datum_now));
        }
        $labels = array_reverse($l);
        $data = array();
        foreach ($labels as $label) {
            $datum = strtotime($label);
            $month = (int)date('m', $datum);
            $year = (int)date('Y', $datum);
            $result = DB::table('corp_mining_tax')
                ->select('quantity', 'volume', 'price')
                ->where('main_character_id', '=', $character)
                ->where('month', '=', $month)
                ->where('year', '=', $year)
                ->first();
            if(!is_null($result)) {
                array_push($data, $result->volume);
                $tmv += $result->volume;
                $tmisk += $result->price;
                $tmq += $result->quantity;
            } else {
                array_push($data, 0);
            }
        }
        return view('corpminingtax::corpminingtaxhome', [
            'total_mined_quantity' => $tmq,
            'total_mined_volume' => $tmv,
            'total_mined_isk' => $tmisk,
            'test' => $character->character_id,
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    public function getCharacterMiningBarChartData()
    {
        //$characters = CharacterHelper::getLinkedCharacters(auth()->user()->main_character['character_id']);
        $character = auth()->user()->main_character['character_id'];
        $l = array();
        $datum_now = date('Y-m', time());

        for ($i = 0; $i < 12; $i++) {
            $m = "-" . $i . "month";
            $datum_now = strtotime($m);
            array_push($l, date('Y-m', (int)$datum_now));
        }
        $labels = array_reverse($l);
        $data = array();
        foreach ($labels as $label) {
            $datum = strtotime($label);
            $month = (int)date('m', $datum);
            $year = (int)date('Y', $datum);
            $result = DB::table('corp_mining_tax')
                ->select('quantity', 'volume', 'price')
                ->where('main_character_id', '=', $character)
                ->where('month', '=', $month)
                ->where('year', '=', $year)
                ->pluck('volume');
            array_push($data, $result);
        }
        return $labels;
    }
}