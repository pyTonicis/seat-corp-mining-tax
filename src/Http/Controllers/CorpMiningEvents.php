<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Http\Controllers;

use Seat\Web\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use View;

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
        $update = DB::table('corp_mining_tax_events')
            ->insert(['event_name' => $request->get('event'), 'event_start' => $request->get('start'),
                'event_duration' => $request->get('duration'), 'event_status' => 1, 'event_tax' => $request->get('taxrate'), 'event_stop' => '1999-12-31']);
        $events = DB::table('corp_mining_tax_events')
            ->get();
        return view('corpminingtax::corpminingevents', ['events' => $events]);
    }

    public function getDetails($eid = 0)
    {
        $event_minings = DB::table('corp_mining_tax_event_minings as em')
            ->select('em.*', 'it.typeName')
            ->join('invTypes as it', 'em.type_id', '=', 'it.typeID')
            ->where('em.event_id', $eid)
            ->orderBy('em.character_name')
            ->get();
        return view::make('corpminingtax::eventdetails', ['event_minings' => $event_minings])->render();
    }

    private function getEventMinings(int $event_id)
    {
        $minings = DB::table('corp_mining_tax_event_minings')
            ->where('event_id', $event_id)
            ->orderBy('character_name')
            ->get();
        return $minings;
    }

    public function getCharacters(Request $request)
    {
        if ($request->has('q')) {
            $data = DB::table('character_infos')
                ->select(
                    'character_id AS id',
                    'name'
                )
                ->where('name', 'LIKE', "%" . $request->get('q') . "%")
                ->orderBy('name', 'asc')
                ->get();
        }
        return response()->json($data);
    }
}