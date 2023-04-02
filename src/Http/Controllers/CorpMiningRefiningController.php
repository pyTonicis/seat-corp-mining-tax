<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Http\Controllers;

use pyTonicis\Seat\SeatCorpMiningTax\Services\Reprocessing;
use Seat\Web\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
class CorpMiningRefiningController extends Controller
{
    public function getHome()
    {
        return view('corpminingtax::corpminingrefining');
    }

    public function getRefinings(Request $request)
    {
        $sum = $request->except('_token');
        $items = $request->get('itmes');
        $data = [];

        foreach($items as $name => $quantity) {
            array_push($data, Reprocessing::ReprocessOreByTypeId(Reprocessing::getItemIdByName($name), $quantity));
        }
        return view('corpminingtax::corpminingrefining', [
            'data' => $data,
        ]);
    }
}