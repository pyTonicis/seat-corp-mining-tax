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
    public function getHome()
    {
        $tmq = 5001;
        $tmv = 500100;
        $tmisk = 535345345325;
        return view('corpminingtax::corpminingtaxhome', [
            'total_mined_quantity' => $tmq,
            'total_mined_volume' => $tmv,
            'total_mined_isk' => $tmisk,
            'test' => CharacterHelper::getLinkedCharacters(auth()->user()->main_character['character_id']),
        ]);
    }

    public function getCharacterMiningBarChartData()
    {
        //$characters = CharacterHelper::getLinkedCharacters(auth()->user()->main_character['character_id']);
        $character = auth()->user()->main_character['character_id'];
        $l = array();
        $datum_now = date('Y-m', time());

        for ($i=0; $i < 12; $i++)
        {
            $m = "-" .$i. "month";
            $datum_now = strtotime($m);
            array_push($l, date('Y-m', (int)$datum_now));
        }
        $labels = array_reverse($l);
        $data = array();
        foreach($labels as $label)
        {
            $month = date('m', $label);
            $year = date('Y', $label);
            $result = DB::table('corp_mining_tax')
                        ->select('quantity', 'volume', 'price')
                        ->where('main_character_id', '=', $character)
                        ->where('month', '=', $month)
                        ->where('year', '=', $year)
                        ->pluck('volume');
            array_push($data, $result);
        }
        return response()->json([
            'labels'   => [
                $labels
            ],
            'datasets' => [
                [
                    'label'           => 'Volume in x1000m³',
                    'data'            => $data,
                    'backgroundColor' => [
                        '#00c0ef',
                        '#39cccc',
                        '#00a65a',
                        '#605ca8',
                        '#001f3f',
                        '#3c8dbc',
                        '#00c0ef',
                        '#00c0ef',
                        '#00c0ef',
                        '#00c0ef',
                        '#00c0ef',
                        '#00c0ef',
                    ],
                    'borderColor' => [
                        '#ff0000',
                        '#00ff00',
                        '#0000ff',
                        '#ff0000',
                        '#00ff00',
                        '#0000ff',
                        '#ff0000',
                        '#00ff00',
                        '#0000ff',
                        '#ff0000',
                        '#00ff00',
                        '#0000ff',
                    ],
                ],
            ],
        ]);
    }
}