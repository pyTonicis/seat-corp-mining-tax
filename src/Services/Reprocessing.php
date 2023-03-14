<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js;
class Reprocessing
{
    private function getReprocessData(int $id)
    {
        $data = DB::table('invTypeMaterials as m')
            ->select('m.materialTypeID', 't.groupID', 'm.quantity', 't.typeName')
            ->LeftJoin('invTypes as t', 'm.materialTypeID', '=', 't.typeID')
            ->where('m.typeID', '=', $id)
            ->get();
        return $data;
    }
}