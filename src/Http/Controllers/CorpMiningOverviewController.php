<?php

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
        $character = auth()->user()->main_character['character_id'];
        $characters = CharacterHelper::getLinkedCharacters($character);
        $labels = array();
        $act_m = (date('m', time()) +0);
        $act_y = (date('Y', time()) -1);
        for ($i = 0; $i < 12; $i++) {
            if ($act_m == 12) {
                $act_y += 1;
                $act_m = 1;
            } else {
                $act_m += 1;
            }
            array_push($labels, date('Y-m', strtotime($act_y . "-" . $act_m)));
        }
        $data = array();
        $prices = array();
        $minings = new CharacterMinings();
        $minings->character_id = $character;
        $minings->labels = $labels;
        $grp_ice = array();
        $grp_ore = array();
        $grp_gas = array();
        $grp_moon = array();
        $grp_abyssal = array();
        $taxes = array();
        $avg_tax = 0;
        $avg_price = 0;
        $tax_count = 0;
        $tax_act = 0;
        foreach ($labels as $label) {
            $datum = strtotime($label);
            $month = (int)date('m', $datum);
            $year = (int)date('Y', $datum);
            $result = DB::table('corp_mining_tax')
                ->selectRAW('sum(quantity) as quantity, sum(volume) as volume, sum(price) as price, sum(tax) as tax, sum(event_tax) as event_tax')
                ->where('main_character_id', '=', $character)
                ->where('month', '=', $month)
                ->where('year', '=', $year)
                ->first();
            if(!is_null($result)) {
                array_push($data, (int)$result->volume);
                array_push($prices, (int)$result->price);
                array_push($taxes, (int)$result->tax);
                $minings->add_volume($result->volume);
                $minings->add_price($result->price);
                $minings->add_quantity($result->quantity);
                $tax_count += (int)$result->tax;
                $tax_act = (int)$result->tax;
            } else {
                array_push($data, 0);
                array_push($prices, 0);
                $tax_act = 0;
            }
            DB::statement("SET SQL_MODE=''");
            $groups = DB::table('character_minings as cm')
                ->selectRaw('cm.type_id, sum(cm.quantity) as quantity, it.typeName, it.groupId, it.volume')
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
                        $ice += (int)$group->quantity * $group->volume;
                    } elseif ($group->groupId == 1884 or ($group->groupId >= 1920 and $group->groupId <= 1923)) {
                        $moon += (int)$group->quantity * $group->volume;
                    } elseif ($group->groupId == 711) {
                        $gas += (int)$group->quantity * $group->volume;
                    } elseif ($group->groupId == 1996) {
                        $abyssal += (int)$group->quantity * $group->volume;
                    } else {
                        $ore += (int)$group->quantity * $group->volume;
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
        $minings->price_per_month = $prices;
        $dataset = array(['label' => 'Ice', 'data' => $grp_ice, 'backgroundColor' => '#4dc9f6'],
                         ['label' => 'Moon', 'data' => $grp_moon, 'backgroundColor' => '#f53794'],
                         ['label' => 'Ore', 'data' => $grp_ore, 'backgroundColor' => '#acc239'],
                         ['label' => 'Gas', 'data' => $grp_gas, 'backgroundColor' => '#166a8f'],
                         ['label' => 'Abyssal', 'data' => $grp_abyssal, 'backgroundColor' => '#e2f516'],
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
                        ->orderBy('year', 'asc')
                        ->orderBy('month', 'asc')
                        ->get();
        $rank = $this->getCharacterMiningRank($character, date('m'), date('Y'));
        $linked_characters = [];
        $linked_characters[0] = "All Characters";
        foreach($characters as $character) {
            $linked_characters[$character] = CharacterHelper::getCharacterName($character);
        }
        $avg_price = (!empty($prices) ? array_sum($prices) / count($prices) : 0);
        $avg_tax = (!empty($taxes) ? array_sum($taxes) / count($taxes) : 0);
        return view('corpminingtax::corpminingtaxhome', [
            'rank' => $rank,
            'tax_count' => $tax_count,
            'tax_act' => $tax_act,
            'labels' => $labels,
            'minings' => $minings,
            'dataset' => $dataset,
            'avg_tax' => $avg_tax,
            'avg_price' => $avg_price,
            'type_labels' => $type_labels,
            'type_quantity' => $type_quantity,
            'miningdata' => $miningdata,
            'characters' => $linked_characters,
        ]);
    }

    private function getCharacterMiningRank(int $character_id, int $month, int $year)
    {
        DB::statement("SET SQL_MODE=''");
        $result = DB::table('corp_mining_tax')
            ->select('tax', 'main_character_id')
            ->where('month', '=', $month)
            ->where('year', '=', $year)
            ->orderBy('tax', 'desc')
            ->get();
        $count = 1;
        foreach($result as $r) {
            if ($r->main_character_id == $character_id)
                break;
            $count += 1;
        }
        return $count;
    }

    public function getMinedChartData($ids = 0)
    {
        $labels = array();
        $data = array();
        $act_m = (date('m', time()) +0);
        $act_y = (date('Y', time()) -1);
        for ($i = 0; $i < 12; $i++) {
            if ($act_m == 12) {
                $act_y += 1;
                $act_m = 1;
            } else {
                $act_m += 1;
            }
            array_push($labels, date('Y-m', strtotime($act_y . "-" . $act_m)));
        }
        foreach ($labels as $label) {
            $datum = strtotime($label);
            $month = (int)date('m', $datum);
            $year = (int)date('Y', $datum);
            if($ids != 0) {
                $result = DB::table('corp_mining_tax')
                    ->select('*')
                    ->whereIn('character_id', '=', $ids)
                    ->where('month', '=', $month)
                    ->where('year', '=', $year)
                    ->first();
            } else {
                $character = auth()->user()->main_character['character_id'];
                $result = DB::table('corp_mining_tax')
                    ->selectRAW('sum(volume) as volume')
                    ->where('main_character_id', '=', $character)
                    ->where('month', '=', $month)
                    ->where('year', '=', $year)
                    ->first();
            }
            if(!is_null($result)) {
                array_push($data, (int)$result->volume);
            } else {
                array_push($data, 0);
            }
        }
        return response()->json(compact('labels','data'));
    }
}
