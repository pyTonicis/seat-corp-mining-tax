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

namespace H4zz4rdDev\Seat\SeatCorpMiningTax\Http\Controllers;

use H4zz4rdDev\Seat\SeatCorpMiningTax\Helpers\CharacterHelper;
use Seat\Web\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

/**
 * Class CorpMiningTaxController
 */
class CorpMiningTaxController extends Controller
{
    private $miningData;

    /**
     * @return mixed
     */
    public function getHome() {
        return view('corpminingtax::corpminingtax');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function getData(Request $request) {

        if(!$request->has('corpId')) {
            return redirect()->route('corpminingtax.home');
        }

        $this->miningData = [];

        $m_data = DB::table('character_minings as cm')
            ->select(
                'cm.character_id',
                'cm.quantity',
                'cm.type_id',
                'it.typeName'
                )
            ->join('corporation_members as cmem', 'cm.character_id', '=', 'cmem.character_id')
            ->join('market_prices as mp', 'cm.type_id', 'mp.type_id')
            ->join('invTypes as it', 'cm.type_id', '=', 'it.typeID')
            ->where('cmem.corporation_id', '=', (int)$request->get('corpId'))
            ->where('cm.month', '=', (int)$request->get('mining_month'))
            ->where('cm.year', '=' , (int)$request->get('mining_year'))
            ->get();

        $this->miningData['month'] = (int)$request->get('mining_month');
        $this->miningData['year'] = (int)$request->get('mining_year');

        foreach ($m_data as $data) {
            $main_character_data = CharacterHelper::getMainCharacterCharacter($data->character_id);
            $this->miningData['miningData'][$main_character_data->main_character_id]['name'] = $main_character_data->name;
            $this->miningData['miningData'][$main_character_data->main_character_id]['ore_types'][$data->type_id]["quantity"] = $data->quantity;

            if(array_key_exists("ore_types" , $this->miningData['miningData'][$main_character_data->main_character_id])) {
                $this->miningData['miningData'][$main_character_data->main_character_id]['ore_types'][$data->type_id]["quantity"] =
                    $this->miningData['miningData'][$main_character_data->main_character_id]['ore_types'][$data->type_id]["quantity"] +
                    $data->quantity;
            } else {
                $this->miningData['miningData'][$main_character_data->main_character_id]['ore_types'][$data->type_id]["quantity"] = $data->quantity;
            }

            if(array_key_exists("ore_summary", $this->miningData['miningData'][$main_character_data->main_character_id])) {
                $this->miningData['miningData'][$main_character_data->main_character_id]['ore_summary'] = $this->miningData['miningData'][$main_character_data->main_character_id]['ore_summary']
                    + $data->quantity;
            } else {
                $this->miningData['miningData'][$main_character_data->main_character_id]['ore_summary'] = $data->quantity;
            }

            $this->miningData['miningData'][$main_character_data->main_character_id]['ore_types'][$data->type_id]["name"] = $data->typeName;
        }

        return view('corpminingtax::corpminingtax', [
            'miningData' => $this->miningData
        ]);
    }

    public function getCorporations(Request $request) {
        if($request->has('q')) {
            $data = DB::table('corporation_infos')
                ->select(
                    'corporation_id AS id',
                    'name'
                )
                ->where('name', 'LIKE', "%" . $request->get('q') . "%")
                ->orderBy('name', 'asc')
                ->get();
        }

        return response()->json($data);
    }
}


