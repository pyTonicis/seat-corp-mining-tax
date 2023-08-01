<?php

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
            ->orderBy('character_name')
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