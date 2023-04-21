<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Services;

use Seat\Web\Http\Controllers\Controller;
use Seat\Eveapi\Models\Character\CharacterInfo;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js;
use Datatables;

class ItemParser
{
    public static function parseItems(string $item_string): ?array
    {
        if (empty($item_string)) {
            return null;
        }

        $sorted_item_data = [];

        foreach (preg_split('/\r\n|\r|\n/', $item_string) as $item) {
            if (stripos($item, "    ")) {
                $item_data_details = explode("    ", $item);
            } elseif (stripos($item, "\t")) {
                $item_data_details = explode("\t", $item);
                $item_name = $item_data_details[0];
                $item_quantity = null;

                foreach ($item_data_details as $item_data_detail) {
                    if (is_numeric(trim($item_data_detail))) {
                        $item_quantity = (int)str_replace('.', '', $item_data_detail);
                    }
                }

                $inv_type = InvType::where('typeName', '=', $item_name)->first();

                if(!is_null($inv_type)) {

                    $inv_group = InvGroup::where('groupID', '=', $inv_type->groupID)->first();
                    if (!array_key_exists($item_name, $sorted_item_data)) {
                        $sorted_item_data[$item_name]["name"] = $item_name;
                        $sorted_item_data[$item_name]["typeID"] = $inv_type->typeID;
                        $sorted_item_data[$item_name]["categoryID"] = $inv_group->categoryID;
                        $sorted_item_data[$item_name]["quantity"] = 0;
                        $sorted_item_data[$item_name]["price"] = 0;
                    }

                    $sorted_item_data[$item_name]["quantity"] += $item_quantity;
                }
            }
        }
        return $sorted_item_data;
    }
}