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
use pyTonicis\Seat\SeatCorpMiningTax\Helpers\EvePraisalHelper;
use pyTonicis\Seat\SeatCorpMiningTax\Services\MiningTaxService;
use Seat\Web\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js;

/**
 * Class CorpMiningTaxController
 */
class CorpMiningTaxController extends Controller
{
    private $miningTaxService;

    private $miningData;

    /**
     * @param MiningTaxService $miningTaxService
     */
    public function __construct(MiningTaxService $miningTaxService)
    {
        $this->miningTaxService = $miningTaxService;
    }

    /**
     * @return mixed
     */
    public function getHome()
    {
        $taxdata = DB::table('corp_mining_tax as t')
            ->select('t.*', 'c.name')
            ->join('character_infos as c', 'main_character_id', '=', 'c.character_id')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        return view('corpminingtax::corpminingtax', [
            'taxdata' => $taxdata,
        ]);
    }

    public function getTest()
    {
        $contracts = DB::table('corp_mining_tax_contracts')
            ->get();
        return view('corpminingtax::corpminingtaxcontracts', ['contracts' => $contracts]);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function getData(Request $request)
    {
        if (!$request->has('corpId')) {
            return redirect()->route('corpminingtax.home');
        }

        $this->miningData = $this->miningTaxService->createMiningTaxResult($request->get('corpId'),
            (int)$request->get('mining_month'), (int)$request->get('mining_year'));

        //dd($this->miningData);

        return view('corpminingtax::corpminingtax', [
            'miningData' => $this->miningData
        ]);
    }

    public function getData2($cid = 0)
    {
        $details = DB::table('corp_mining_tax_contracts')
            ->select('*')
            ->where('id', '=', $cid)
            ->first();
        $html = "<table class=\"table table-sm no-border\">";
        $html .= "<tbody><tr>";
        $html .= "<td><b>Contract to</b></td><td>" .$details->character_name ."</td></tr><tr>";
        $html .= "<td><b>Contract Title</b></td><td>" .$details->contractTitle ."</td></tr><tr>";
        $html .= "<td><b>Contract Type</b></td><td>ItemExchange</td></tr><tr>";
        $html .= "<td><b>Tax</b></td><td>" .number_format($details->tax). "</td></tr></tbody></table>";
        $response['html'] = $html;
        return response()->json($response);
    }

    public function getDashboard(Request $request)
    {
        return view('corpminingtaxhome::corpminingtaxhome');
    }
    public function getCorporations(Request $request)
    {
        if ($request->has('q')) {
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


