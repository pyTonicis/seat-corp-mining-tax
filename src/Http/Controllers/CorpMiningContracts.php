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

use Seat\Web\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js;
class CorpMiningContracts extends Controller
{
    public function getHome()
    {
        $contracts = DB::table('corp_mining_tax_contracts')
            ->get();
        return view('corpminingtax::corpminingtaxcontracts', ['contracts' => $contracts]);
    }

    public function getDetails($cid = 0)
    {
        $details = DB::table('corp_mining_tax_contracts')
            ->select('*')
            ->where('id', '=', $cid)
            ->first();
        $html = "<table class=\"table table-sm no-border\"><tbody><tr>";
        $html .= "<td><b>Contract to</b></td><td id='c_name'>" .$details->character_name ."</td><td><button class='btn btn-sm copy-data' data-toggle='tooltip' data-export=".$details->character_name."><i class='fas fa-copy'></i></button></td></tr><tr>";
        $html .= "<td><b>Contract Title</b></td><td id='c_title'>" .$details->contractTitle ."</td><td><button class='btn btn-sm copy-data' data-toggle='tooltip' data-export='c_title'><i class='fas fa-copy'></i></button></td></tr><tr>";
        $html .= "<td><b>Contract Type</b></td><td>ItemExchange</td><td></td></tr><tr>";
        $html .= "<td><b>Tax</b></td><td id='c_tax'>" .number_format($details->tax). "</td><td><button class='btn btn-sm copy-data' data-toggle='tooltip' data-export='c_tax'><i class='fas fa-copy'></i></button></td></tr></tbody></table>";
        $response['html'] = $html;
        return response()->json($response);
    }

    public function setContractOffered(Request $request)
    {
        $cid = $request->get('cid');
        if ($cid != 0) {
            DB::table('corp_mining_tax_contracts')
                ->where('id', $cid)
                ->update(['contractStatus' => 2]);
        }
        return redirect()->back()->with('status', 'Contract successful offered');
    }

    public function removeContract(Request $request)
    {
        $cid = $request->get('cid');
        if ($cid != 0) {
            DB::table('corp_mining_tax_contracts')
                ->where('id', $cid)
                ->delete();
        }
        return redirect()->back()->with('status', 'Contract successful deleted');
    }

    public function filterContracts(Request $request)
    {
        if ($request->get('status')) {
            $data = DB::table('corp_mining_tax_contracts')
                ->where('contractStatus', '=', $request->get('status'))
                ->get();
            return view('corpminingtax::corpminingtaxcontracts', ['contracts' => $data]);
        }
    }
}