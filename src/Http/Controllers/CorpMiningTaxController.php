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
        return view('corpminingtax::corpminingtax');
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


