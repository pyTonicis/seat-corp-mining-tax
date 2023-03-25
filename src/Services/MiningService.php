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
            foreach($groups as $group)
            $mining_group = new MiningGroups();
            if (!is_null($group)) {
                if ($group->groupId == 465) {
                    $mining_group->group_name = "Ice";
                } elseif ($group->groupId == 1884) {
                    $mining_group->group_name = "R4";
                } elseif ($group->groupId == 1920) {
                    $mining_group->group_name = "R8";
                } elseif ($group->groupId == 1921) {
                    $mining_group->group_name = "R16";
                } elseif ($group->groupId == 1922) {
                    $mining_group->group_name = "R32";
                } elseif ($group->groupId == 1923) {
                    $mining_group->group_name = "R64";
                } elseif ($group->groupId == 711) {
                    $mining_group->group_name = "Gas";
                } else {
                    $mining_group->group_name = "Ore";
                }
                $mining_group->group_id = $group->groupId;
                $mining_group->quantity = $group->quantity;
                $mining_group->type_name = $group->typeName;
                $mining_group->type_id = $group->type_id;
            }
        }
        return $minings;
    }

}