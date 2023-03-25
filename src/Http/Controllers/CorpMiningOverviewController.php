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
use pyTonicis\Seat\SeatCorpMiningTax\Models\Mining\CharacterMinings;
use Seat\Web\Http\Controllers\Controller;
use Seat\Eveapi\Models\Character\CharacterInfo;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js;
use Datatables;

class CorpMiningOverviewController extends Controller
{
    public function getHome()
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
        $groups = array();
        $minings = new CharacterMinings();
        $minings->character_id = $character;
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
                array_push($data, (int)$result->volume);
                $tmv += $result->volume;
                $minings->add_volume($result->volume);
                $tmisk += $result->price;
                $minings->add_price($result->price);
                $tmq += $result->quantity;
                $minings->add_quantity($result->quantity);
            } else {
                array_push($data, 0);
            }
        }
        $minings->volume_per_month = $data;
        $mydata = $this->getCharacterMiningGroupsData($character, 3, 2023);
        return view('corpminingtax::corpminingtaxhome', [
            'total_mined_quantity' => $tmq,
            'total_mined_volume' => $tmv,
            'total_mined_isk' => $tmisk,
            'test' => $mydata,
            'labels' => $labels,
            'minings' => $minings,
        ]);
    }

    public function getCharacterMiningGroupsData(int $character_id, int $month, int $year)
    {
        DB::statement("SET SQL_MODE=''");
        $result = DB::table('character_minings as cm')
                    ->selectRaw('cm.type_id, sum(cm.quantity) as quantity, it.typeName, it.groupId')
                    ->join('invTypes as it', 'cm.type_id', '=', 'it.typeId')
                    ->where('cm.character_id', '=', $character_id)
                    ->where('cm.month', '=', $month)
                    ->where('cm.year', '=', $year)
                    ->groupBy('it.groupId')
                    ->get();
        return $result;
    }
}
