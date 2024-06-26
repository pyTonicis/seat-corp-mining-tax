<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Http\Controllers;

use DateTime;
use pyTonicis\Seat\SeatCorpMiningTax\Helpers\CharacterHelper;
use pyTonicis\Seat\SeatCorpMiningTax\Services\ItemParser;
use pyTonicis\Seat\SeatCorpMiningTax\Services\Reprocessing;
use Seat\Web\Http\Controllers\Controller;
use Seat\Eveapi\Models\Sde\InvType;
use Seat\Eveapi\Models\Sde\InvGroup;
use Seat\Eveapi\Models\Market\Price;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use View;

class CorpMiningEvents extends Controller
{
    public function getHome()
    {
        //DB::statement("SET SQL_MODE=''");
        //$status = DB::update(DB::raw("update corp_mining_tax_events set event_status=2 where event_start <= date(now()) and event_stop >= date(now())"));
        //$status = DB::update(DB::raw("update corp_mining_tax_events set event_status=3 where event_stop < date(now())"));
        DB::statement("SET SQL_MODE=''");
        $events = DB::table('corp_mining_tax_events as e')
            ->selectRAW('e.*, IFNULL(sum(m.refined_price), 0) as total')
            ->leftJoin('corp_mining_tax_event_minings as m', 'e.id', '=', 'm.event_id')
            ->groupBy('e.id')
            ->get();
        return view('corpminingtax::corpminingevents', ['events' => $events]);
    }

    public function eventCmd(Request $request)
    {
        redirect()->back();
    }

    public function createEvent(Request $request)
    {
        $dt = new DateTime($request->get('start'));
        $event_stop = $dt->modify("+ ".$request->get('duration'). " day");
        DB::table('corp_mining_tax_events')
            ->insert(['event_name' => $request->get('event'), 'event_start' => $request->get('start'),
                'event_duration' => $request->get('duration'), 'event_status' => 1, 'event_tax' => $request->get('taxrate'), 'event_stop' => $event_stop,
                'event_valuation' => $request->get('valuation'), 'event_tracker' => $request->get('event_tracker')]);
        return redirect()->action([CorpMiningEvents::class, 'getHome']);
    }

    public function addMining(Request $request)
    {
        $event_id = $request->get('event_id');
        $character = CharacterHelper::getCharacterName($request->get('character'));
        $parsed_items = ItemParser::parseItems($request->get('ore'));
        $refinedMaterials = [];

        foreach($parsed_items as $key => $item) {

            $summary = 0;
            $raw = Reprocessing::ReprocessOreByTypeId($item['typeID'], $item['quantity']);
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
            DB::table('corp_mining_tax_event_minings')
                ->updateOrInsert(['character_name' => $character, 'event_id' => $event_id, 'type_id' => $item['typeID'], 'quantity' => $item['quantity'], 'refined_price' => $summary]);
        }
        return redirect()->back()->with('status', "Successful added...");
    }

    public function delMining(Request $request)
    {
        $cid = $request->get('cid');
        if ($cid != 0) {
            DB::table('corp_mining_tax_event_minings')
                ->where('id', $cid)
                ->delete();
        }
        return redirect()->back()->with('status', "Successful removed...");
    }

    public function getDetails($eid = 0)
    {
        $event_minings = DB::table('corp_mining_tax_event_minings as em')
            ->select('em.*', 'it.typeName')
            ->join('invTypes as it', 'em.type_id', '=', 'it.typeID')
            ->where('em.event_id', $eid)
            ->orderBy('em.character_name')
            ->get();
        $characters = CharacterHelper::getMainCharacters();
        $total_mined_isk = DB::table('corp_mining_tax_event_minings')
            ->selectRAW('sum(refined_price) as tax')
            ->where('event_id', $eid)
            ->first();
        $total_characters = DB::table('corp_mining_tax_event_minings')
            ->selectRaw('count(DISTINCT character_name) as members')
            ->where('event_id', '=', $eid)
            ->first();
        $event_data = DB::table('corp_mining_tax_events')
            ->where('id', '=', $eid)
            ->first();
        return view::make('corpminingtax::eventdetails', ['event_minings' => $event_minings, 'characters' => $characters,
            'event_id' => $eid, 'total_mined_isk' => $total_mined_isk->tax, 'total_members' => $total_characters->members,
            'event_data' => $event_data])->render();
    }

    public function getDetailsRaw($eid = 0)
    {
        $event_minings = DB::table('corp_mining_tax_event_minings as em')
            ->select('em.*', 'it.typeName')
            ->join('invTypes as it', 'em.type_id', '=', 'it.typeID')
            ->where('em.event_id', $eid)
            ->groupBy('em.type_id')
            ->get();
        $characters = CharacterHelper::getMainCharacters();
        $total_mined_isk = DB::table('corp_mining_tax_event_minings')
            ->selectRAW('sum(refined_price) as tax')
            ->where('event_id', $eid)
            ->first();
        $total_characters = DB::table('corp_mining_tax_event_minings')
            ->selectRaw('count(DISTINCT character_name) as members')
            ->where('event_id', '=', $eid)
            ->first();
        $event_data = DB::table('corp_mining_tax_events')
            ->where('id', '=', $eid)
            ->first();
        return view::make('corpminingtax::eventdetails', ['event_minings' => $event_minings, 'characters' => $characters,
            'event_id' => $eid, 'total_mined_isk' => $total_mined_isk->tax, 'total_members' => $total_characters->members,
            'event_data' => $event_data])->render();
    }

    private function getEventMinings(int $event_id)
    {
        $minings = DB::table('corp_mining_tax_event_minings')
            ->where('event_id', $event_id)
            ->orderBy('character_name')
            ->get();
        return $minings;
    }

    public function removeEvent(Request $request)
    {
        $cid = $request->get('cid');
        DB::table('corp_mining_tax_events')
            ->where('id', '=', $cid)
            ->delete();
        return redirect()->back()->with('status', "Successful removed...");
    }
}