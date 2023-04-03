<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Http\Controllers;

use pyTonicis\Seat\SeatCorpMiningTax\Services\Reprocessing;
use Seat\Web\Http\Controllers\Controller;
use Seat\Eveapi\Models\Sde\InvType;
use Seat\Eveapi\Models\Market\Price;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CorpMiningRefiningController extends Controller
{
    public function getHome()
    {
        return view('corpminingtax::corpminingrefining');
    }

    public function reprocessItems(Request $request)
    {
        $request->validate([
            'items' => 'required',
        ]);

        $parsedOre = $this->parseItems($request->get('items'));
        $refinedMaterials = [];
        $summary = 0;

        foreach($parsedOre as $key => $item) {
            $raw = Reprocessing::ReprocessOreByTypeId($item['typeID'], $item['quantity'], ((float)$request->get('modifier') / 100));
            foreach($raw as $n => $value) {
                $inv_type = InvType::where('typeId', '=', $n)->first();
                $price = Price::where('type_id', '=', $n)->first();
                if (!array_key_exists($inv_type->typeName, $refinedMaterials)) {
                    $refinedMaterials[$inv_type->typeName]['name'] = $inv_type->typeName;
                    $refinedMaterials[$inv_type->typeName]['typeID'] = $n;
                    $refinedMaterials[$inv_type->typeName]['quantity'] = $value;
                    $refinedMaterials[$inv_type->typeName]['price'] = $price->average_price;
                    $summary += (int)$price->average_price * (int)$value;
                } else {
                    $refinedMaterials[$inv_type->typeName]['quantity'] += $value;
                    $summary += (int)$price->average_price * (int)$value;
                }
            }
        }
        return view('corpminingtax::corpminingrefining', [
            'data' => $parsedOre,
            'data2' => $refinedMaterials,
            'total' => $summary,
        ]);
    }

    private function parseItems(string $item_string): ?array
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

                if (!array_key_exists($item_name, $sorted_item_data)) {
                    $sorted_item_data[$item_name]["name"] = $item_name;
                    $sorted_item_data[$item_name]["typeID"] = $inv_type->typeID;
                    $sorted_item_data[$item_name]["quantity"] = 0;
                    $sorted_item_data[$item_name]["price"] = 0;
                    $sorted_item_data[$item_name]["sum"] = 0;
                }

                $sorted_item_data[$item_name]["quantity"] += $item_quantity;
            }
        }
        return $sorted_item_data;
    }
}