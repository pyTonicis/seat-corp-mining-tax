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
use View;

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
        return view::make('corpminingtax::contractdetails', ['details' => $details])->render();
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

    public function setContractCompleted(Request $request)
    {
        $cid = $request->get('cid');
        if ($cid != 0) {
            DB::table('corp_mining_tax_contracts')
                ->where('id', $cid)
                ->update(['contractStatus' => 3]);
        }
        return redirect()->back()->with('status', 'Contract successful complited');
    }
    public function removeContract(Request $request)
    {
        $cid = $request->get('cid');
        if ($cid != 0) {
            DB::table('corp_mining_tax_contracts')
                ->where('id', $cid)
                ->delete();
        }
        //return redirect()->back()->with('status', 'Contract successful deleted');
        //return redirect()->route('corpminingtax.contracts')->with('status', 'Contract successful deleted!');
        $contracts = DB::table('corp_mining_tax_contracts')
            ->get();
        return view('corpminingtax::corpminingtaxcontracts', ['contracts' => $contracts]);
    }

    public function editContract(Request $request)
    {
        $contracts = DB::table('corp_mining_tax_contracts')
            ->get();
        return view('corpminingtax::corpminingtaxcontracts', ['contracts' => $contracts]);
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