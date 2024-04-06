<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Http\Controllers;

use pyTonicis\Seat\SeatCorpMiningTax\Helpers\CharacterHelper;
use pyTonicis\Seat\SeatCorpMiningTax\Services\MiningTaxService;
use pyTonicis\Seat\SeatCorpMiningTax\Services\SettingService;
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

    private $settingService;

    /**
     * @param MiningTaxService $miningTaxService
     */
    public function __construct(MiningTaxService $miningTaxService)
    {
        $this->miningTaxService = $miningTaxService;
        $this->settingService = new SettingService();
    }

    /**
     * @return mixed
     */
    public function getHome()
    {
        if($this->settingService->getValue('mining_tax_calculation') == 'combined') {
            DB::statement("SET SQL_MODE=''");
            $taxdata = DB::table('corp_mining_tax as t')
                ->selectRaw('sum(t.quantity) as quantity, sum(t.volume) as volume, sum(t.price) as price, sum(t.tax) as tax, sum(event_tax) as event_tax, c.name')
                ->join('character_infos as c', 'main_character_id', '=', 'c.character_id')
                ->where('year', date('Y', time()))
                ->where('month', date('m', time()))
                ->where('corporation_id', '=', $this->settingService->getValue('corporation_id'))
                ->orderBy('c.name')
                ->groupBy('t.main_character_id')
                ->get();
        } else {
            $taxdata = DB::table('corp_mining_tax as t')
                ->select('t.*', 'c.name')
                ->join('character_infos as c', 't.character_id', '=', 'c.character_id')
                ->where('year', date('Y', time()))
                ->where('month', date('m', time()))
                ->where('corporation_id', '=', $this->settingService->getValue('corporation_id'))
                ->orderBy('c.name')
                ->get();
        }
        $total_tax = 0;
        foreach($taxdata as $tax) {
            $total_tax += $tax->tax;
        }
        return view('corpminingtax::corpminingtax', [
            'taxdata' => $taxdata,
            'total_tax' => $total_tax,
        ]);
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
            (int)$request->get('mining_month'), (int)$request->get('mining_year'), $request->get('tax_calculation'));

        return view('corpminingtax::corpminingtax', [
            'miningData' => $this->miningData
        ]);
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


