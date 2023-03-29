<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Http\Controllers;

use pyTonicis\Seat\SeatCorpMiningTax\Models\Mining\CorporationMoonMining;
use pyTonicis\Seat\SeatCorpMiningTax\Models\Mining\ObserverData;
use pyTonicis\Seat\SeatCorpMiningTax\Models\Mining\MoonMinings;
use pyTonicis\Seat\SeatCorpMiningTax\Services\SettingService;
use Seat\Web\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js;

class CorpMiningMoonMinings extends Controller
{
    private $MoonObservers;
    private $extractions = [];

    private $settingService;

    public function __construct()
    {
        $this->settingService = new SettingService();
    }
    public function getHome()
    {
        $observers = DB::table('corporation_industry_mining_observers as o')
            ->select(
                'o.observer_id',
                's.name',
                'so.name as system_name'
            )
            ->join('universe_structures as s', 'o.observer_id', '=', 's.structure_id')
            ->join('solar_systems as so', 's.solar_system_id', '=', 'so.system_id')
            ->where('o.corporation_id', '=', $this->settingService->getValue('corporation_id'))
            ->orderBy('s.name', 'desc')
            ->get();
        DB::statement("SET SQL_MODE=''");
        $minings = DB::table('corporation_industry_mining_observer_data as od')
            ->selectRAW("od.last_updated, od.observer_id, sum(od.quantity) as quantity, it.typeName, it.groupId")
            ->join('invTypes as it', 'od.type_id', '=', 'it.typeId')
            ->groupby('type_id')
            ->get();
        $moondata = new CorporationMoonMining();
        foreach ($observers as $observer) {
            if (!$moondata->has_observer($observer->observer_id)) {
                $observerData = new ObserverData();
                $observerData->observer_id = $observer->observer_id;
                $observerData->observer_name = $observer->name;
                $observerData->system_name = $observer->system_name;
                $moondata->add_observer($observerData);
            }
        }
        foreach ($minings as $mining) {
            if($moondata->has_observer($mining->observer_id)) {
                if(!$moondata->observers[$mining->observer_id]->has_mining_record($mining->date)) {
                    $data = new MoonMinings();
                    $data->date = $mining->last_updated;
                    $data->add_ore_type($mining->typeName, $mining->quantity);
                    $moondata->observers[$mining->date]->add_mining_record($data);
                } else {
                    $moondata->observers[$mining->date]->minings->add_ore_type($mining->typeName, $mining->quantity);
                }
            }
        }

        return view('corpminingtax::corpmoonmining', ['data' => $moondata]);
    }

    public function getCorpObservers(Request $request)
    {
        $data = DB::table('corporation_industry_mining_observers as o')
            ->select(
                'o.observer_id',
                's.name'
            )
            ->LeftJoin('universe_structures as s', 'o.observer_id', '=', 's.structure_id')
            ->where('o.corporation_id', '=', '98496411')
            ->orderBy('s.name', 'desc')
            ->get();
        return view('corpminingtax::corpmoonmining', ['data' => $data]);
    }

    public function getCorpMoonExtractions(int $id)
    {
        $data = DB::table('corporation_industry_mining_observer_data')
            ->select(
                'last_updated',
            )
            ->selectRAW("sum(quantity) as quantity")
            ->groupby('last_updated')
            ->where('observer_id', $id)
            ->get();
        return $data;
    }

    public function getMoonObservers(Request $request)
    {
        $data = DB::table('corporation_industry_mining_observers as o')
            ->select(
                'o.observer_id as id',
                's.name as name'
            )
            ->LeftJoin('universe_structures as s', 'o.observer_id', '=', 's.structure_id')
            ->where('o.corporation_id', '=', '98496411')
            ->orderBy('s.name', 'desc')
            ->get();
        return response()->json($data);
    }

    public function getCorpMoonMiningData(Request $request)
    {
        /*$data = DB::table('corporation_industry_mining_observers as o')
            ->select(
                'o.observer_id',
                's.name'
            )
            ->LeftJoin('universe_structures as s', 'o.observer_id', '=', 's.structure_id')
            ->where('o.corporation_id', '=', '98496411')
            ->orderBy('s.name', 'desc')
            ->get();*/
        $minings = $this->getCorpMoonExtractions((int)$request->get('observer'));
        $name = DB::table('universe_structures')
            ->select('structure_id','name')
            ->where('structure_id', '=', (int)$request->get('observer'))
            ->first();
        $ore = [];
        foreach($minings as $d)
        {
            $ore_types = DB::table('corporation_industry_mining_observer_data')
                ->select(
                    'type_id'
                )
                ->selectRAW('sum(quantity) as quantity')
                //->LeftJoin('invTypes as i', 'type_id', '=', 'i.typeID')
                ->groupBy('type_id')
                ->where('observer_id', '=', (int)$request->get('observer'))
                ->where('last_updated', '=', $d->last_updated)
                ->get();
            $ore[$d->last_updated] = $ore_types;
        }
        return view('corpminingtax::corpmoonmining', ['ore' => $ore, 'minings' => $minings, 'name' => $name]);
    }
}