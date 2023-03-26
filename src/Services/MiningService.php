<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Services;

use pyTonicis\Seat\SeatCorpMiningTax\Helpers\CharacterHelper;
use pyTonicis\Seat\SeatCorpMiningTax\Models\Mining\CharacterMinings;
use pyTonicis\Seat\SeatCorpMiningTax\Models\Mining\MiningGroups;
use Seat\Web\Http\Controllers\Controller;
use Seat\Eveapi\Models\Character\CharacterInfo;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js;
use Datatables;
/**
 * Class MiningService
 */
class MiningService
{

    public function createCharacterMiningResult(int $character_id): CharacterMinings
    {
        $minings = new CharacterMinings();
        $l = array();
        $datum_now = date('Y-m', time());

        for ($i = 0; $i < 12; $i++) {
            $m = "-" . $i . "month";
            $datum_now = strtotime($m);
            array_push($l, date('Y-m', (int)$datum_now));
        }
        $minings->labels = array_reverse($l);
        $minings->character_id = $character_id;
        $grp_ice = array();
        $grp_ore = array();
        $grp_gas = array();
        $grp_moon = array();
        foreach ($minings->labels as $label) {
            $month = (int)date('m', strtotime($label));
            $year = (int)date('Y', strtotime($label));
            $result = DB::table('corp_mining_tax')
                ->select('quantity', 'volume', 'price')
                ->where('main_character_id', '=', $character_id)
                ->where('month', '=', $month)
                ->where('year', '=', $year)
                ->first();
            if (!is_null($result)) {
                array_push($minings->volume_per_month, (int)$result->volume);
                $minings->add_volume($result->volume);
                $minings->add_price($result->price);
                $minings->add_quantity($result->quantity);
            } else {
                array_push($minings->volume_per_month, 0);
            };
            DB::statement("SET SQL_MODE=''");
            $groups = DB::table('character_minings as cm')
                ->selectRaw('cm.type_id, sum(cm.quantity) as quantity, it.typeName, it.groupId')
                ->join('invTypes as it', 'cm.type_id', '=', 'it.typeId')
                ->where('cm.character_id', '=', $character_id)
                ->where('cm.month', '=', $month)
                ->where('cm.year', '=', $year)
                ->groupBy('it.groupId')
                ->get();
            foreach ($groups as $group)
            if (!is_null($group)) {
                if ($group->groupId == 465) {
                    array_push($grp_ice, $group->quantity);
                } elseif ($group->groupId == 1884) {
                    array_push($grp_moon, $group->quantity);
                } elseif ($group->groupId == 1920) {
                    array_push($grp_moon, $group->quantity);
                } elseif ($group->groupId == 1921) {
                    array_push($grp_moon, $group->quantity);
                } elseif ($group->groupId == 1922) {
                    array_push($grp_moon, $group->quantity);
                } elseif ($group->groupId == 1923) {
                    array_push($grp_moon, $group->quantity);
                } elseif ($group->groupId == 711) {
                    array_push($grp_gas, $group->quantity);
                } else {
                    array_push($grp_ore, $group->quantity);
                }
            }
        }
        return $minings;
    }
}