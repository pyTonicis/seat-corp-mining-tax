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
            'test' => auth()->user()->main_character['character_id'],
        ]);
    }

    public function getCharacterMiningData()
    {

        /*$data = $this->getCharacterSkillsAmountPerLevel($character->character_id);

        return response()->json([
            'labels'   => [
                'Level 0', 'Level 1', 'Level 2', 'Level 3', 'Level 4', 'Level 5',
            ],
            'datasets' => [
                [
                    'data'            => $data,
                    'backgroundColor' => [
                        '#00c0ef',
                        '#39cccc',
                        '#00a65a',
                        '#605ca8',
                        '#001f3f',
                        '#3c8dbc',
                    ],
                ],
            ],
        ]);*/

    }
}