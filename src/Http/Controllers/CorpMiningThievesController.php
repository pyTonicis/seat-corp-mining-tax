<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Http\Controllers;

use pyTonicis\Seat\SeatCorpMiningTax\Services\SettingService;
use pyTonicis\Seat\SeatCorpMiningTax\Services\ThievesService;
use Seat\Web\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use pyTonicis\Seat\SeatCorpMiningTax\Models\Mining\ThievesResult;

class CorpMiningThievesController extends Controller
{
    private $characterList;

    private $ThievesService;


    public function __construct(ThievesService $thievesService)
    {
        $this->ThievesService = $thievesService;
        $this->settingService = new SettingService();
    }

    public function getDataOLD()
    {
        $data = DB::table('corporation_industry_mining_observer_data')
            ->select(
                'corporation_id AS id',
                'observer_id',
                'character_id',
                'recorded_corporation_id',
                'quantity',
                'created_at'
            )
            ->join('corporation_industry_mining_observers AS cobs', 'cobs.observer_id', 'cobs.corporation_id')
            ->join('character_infos AS ci', 'ci.character_id', 'ci.name')
            ->where('observer_id', '=', 'cobs.observer_id')
            ->where('recorded_corporation_id', '!=', $this->settingService->getValue('corporation_id'))
            ->get();
        $result = new ThievesResult();

        return view('corpmoonmining::corpmoonmining', [
            'data' => $data
        ]);
    }

    public function getData()
    {
        $settings = $this->settingService->getAll();
        $this->characterList = $this->ThievesService->createIllegalMiningResult($settings['corporation_id']);
        if (!$this->characterList)
            return view('corpminingtax::corpminingthieves', [
                'result' => $this->characterList
            ]);
        else
            return view('corpminingtax::corpminingthieves');

    }
}