<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Http\Controllers;

use Seat\Web\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
class CorpMiningEvents extends Controller
{
    public function getHome()
    {
        $events = DB::table('corp_mining_tax_events')
            ->get();
        return view('corpminingtax::corpminingevents', ['events' => $events]);
    }

    public function eventCmd(Request $request)
    {
        redirect()->back();
    }

    public function createEvent(Request $request)
    {
        $events = DB::table('corp_mining_tax_events')
            ->get();
        return view('corpminingtax::corpminingevents', ['events' => $events]);
    }

    public function getDetails($cid = 0)
    {
        return view::make('corpminingtax::eventdetails')->render();
    }
}