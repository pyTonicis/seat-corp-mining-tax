<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Http\Controllers;

use pyTonicis\Seat\SeatCorpMiningTax\Helpers\EveJaniceHelper;
use pyTonicis\Seat\SeatCorpMiningTax\Services\ItemParser;
use pyTonicis\Seat\SeatCorpMiningTax\Services\Reprocessing;
use Seat\Web\Http\Controllers\Controller;
use Seat\Eveapi\Models\Sde\InvType;
use Seat\Eveapi\Models\Sde\InvGroup;
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

        $parsedOre = ItemParser::parseItems($request->get('items'));
        $refinedMaterials = [];
        $summary = 0;

        foreach($parsedOre as $key => $item) {

            if ($item['categoryID'] != 25) {
                return redirect()->back()->withError('error', "ERROR: ".$item['name'] ." is not reprocessable...");
            }

            $raw = Reprocessing::ReprocessOreByTypeId($item['typeID'], $item['quantity'], ((float)$request->get('modifier') / 100));
            foreach($raw as $n => $value) {
                $inv_type = InvType::where('typeId', '=', $n)->first();
                if ($request->get('provider') == 'Eve Market')
                    $price = Price::where('type_id', '=', $n)->first()->average_price;
                else
                    $price = EveJaniceHelper::getItemPriceByTypeId($n);
                if (!array_key_exists($inv_type->typeName, $refinedMaterials)) {
                    $refinedMaterials[$inv_type->typeName]['name'] = $inv_type->typeName;
                    $refinedMaterials[$inv_type->typeName]['typeID'] = $n;
                    $refinedMaterials[$inv_type->typeName]['quantity'] = $value;
                    $refinedMaterials[$inv_type->typeName]['price'] = $price;
                    $summary += (int)$price * (int)$value;
                } else {
                    $refinedMaterials[$inv_type->typeName]['quantity'] += $value;
                    $summary += (int)$price * (int)$value;
                }
            }
        }
        return view('corpminingtax::corpminingrefining', [
            'data' => $parsedOre,
            'data2' => $refinedMaterials,
            'total' => $summary,
        ]);
    }

}