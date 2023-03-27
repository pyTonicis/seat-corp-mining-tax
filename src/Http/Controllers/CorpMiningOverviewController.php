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
        $characters = CharacterHelper::getLinkedCharacters($character);
        $linked_characters_count = 5;
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
        $minings->labels = $labels;
        $grp_ice = array();
        $grp_ore = array();
        $grp_gas = array();
        $grp_moon = array();
        $grp_abyssal = array();
        $tax_count = 0;
        $tax_act = 0;
        foreach ($labels as $label) {
            $datum = strtotime($label);
            $month = (int)date('m', $datum);
            $year = (int)date('Y', $datum);
            $result = DB::table('corp_mining_tax')
                ->select('quantity', 'volume', 'price', 'tax')
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
                $tax_count += (int)$result->tax;
                $tax_act = (int)$result->tax;
            } else {
                array_push($data, 0);
            }
            DB::statement("SET SQL_MODE=''");
            $groups = DB::table('character_minings as cm')
                ->selectRaw('cm.type_id, sum(cm.quantity) as quantity, it.typeName, it.groupId')
                ->join('invTypes as it', 'cm.type_id', '=', 'it.typeId')
                ->whereIn('cm.character_id', $characters)
                ->where('cm.month', '=', $month)
                ->where('cm.year', '=', $year)
                ->groupBy('it.groupId')
                ->get();
            $ice = 0;
            $gas = 0;
            $moon = 0;
            $ore = 0;
            $abyssal = 0;
            foreach ($groups as $group) {
                if (!is_null($group)) {
                    if ($group->groupId == 465) {
                        $ice += (int)$group->quantity * 1000;
                    } elseif ($group->groupId == 1884 or ($group->groupId >= 1920 and $group->groupId <= 1923)) {
                        $moon += (int)$group->quantity *10;
                    } elseif ($group->groupId == 711) {
                        $gas += (int)$group->quantity *2;
                    } elseif ($group->groupId == 1996) {
                        $abyssal += (int)$group->quantity /5;
                    } else {
                        $ore += (int)$group->quantity * 16;
                    }
                }
            }
            array_push($grp_ice, (int)$ice);
            array_push($grp_moon, (int)$moon);
            array_push($grp_gas, (int)$gas);
            array_push($grp_ore, (int)$ore);
            array_push($grp_abyssal, (int)$abyssal);
        }
        $minings->volume_per_month = $data;
        $dataset = array(['label' => 'Ice', 'data' => $grp_ice, 'backgroundColor' => '#4dc9f6'],
                         ['label' => 'Moon', 'data' => $grp_moon, 'backgroundColor' => '#f53794'],
                         ['label' => 'Ore', 'data' => $grp_ore, 'backgroundColor' => '#acc239'],
                         ['label' => 'Gas', 'data' => $grp_gas, 'backgroundColor' => '#166a8f'],
                         ['label' => 'Abyssal', 'data' => $grp_abyssal, 'backgroundColor' => '#ff0099'],
            );
        DB::statement("SET SQL_MODE=''");
        $ore_types = DB::table('character_minings as cm')
            ->selectRaw('cm.type_id, sum(cm.quantity) as quantity, it.typeName, it.groupId')
            ->join('invTypes as it', 'cm.type_id', '=', 'it.typeId')
            ->whereIn('cm.character_id', $characters)
            ->where('cm.date', '>=', date('Y-m-01 00:00:00', strtotime('-1 years', time())))
            ->groupBy('cm.type_id')
            ->get();
        $type_labels = array();
        $type_quantity = array();
        foreach($ore_types as $ore)
        {
            array_push($type_labels, $ore->typeName);
            array_push($type_quantity, (int)$ore->quantity);
        }
        $miningdata = DB::table('corp_mining_tax')
                        ->select('*')
                        ->where('main_character_id', '=', $character)
                        ->get();
        return view('corpminingtax::corpminingtaxhome', [
            'linked_characters' => $linked_characters_count,
            'tax_count' => $tax_count,
            'tax_act' => $tax_act,
            'labels' => $labels,
            'minings' => $minings,
            'dataset' => $dataset,
            'type_labels' => $type_labels,
            'type_quantity' => $type_quantity,
            'miningdata' => $miningdata,
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
