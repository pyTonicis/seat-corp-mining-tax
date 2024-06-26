<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js;
use Illuminate\Support\Facades\Cache;

class Reprocessing
{
    private static function getReprocessData(int $id)
    {
        $rname = "tax_r_" .$id;
        if (Cache::get($rname)) {
            return Cache::get($rname);
        } else {
            $data = DB::table('invTypeMaterials as m')
                ->select('m.materialTypeID', 't.groupID', 'm.quantity', 't.typeName')
                ->LeftJoin('invTypes as t', 'm.materialTypeID', '=', 't.typeID')
                ->where('m.typeID', '=', $id)
                ->get();
            Cache::put($rname, $data, 86400);
            return $data;
        }
    }

    public static function getMaterialInfo(int $id)
    {
        $mname = "tax_m_" .$id;
        if (Cache::has($mname)) {
            return Cache::get($mname);
        } else {
            $data = DB::table('invTypes as it')
                ->select('it.groupID', 'it.mass', 'it.volume', 'it.portionSize', 'it.typeName', 'ig.CategoryId')
                ->join('invGroups as ig', 'it.groupID', '=', 'ig.groupID')
                ->where('typeID', '=', $id)
                ->first();
            Cache::put($mname, $data, 86400);
            return $data;
        }
    }

    public static function getItemIdByName(string $name): int
    {
        $cname = "tax_item_" .$name;
        if (Cache::has($cname)) {
            return Cache::get($cname);
        } else {
            $id = DB::table('invTypes')
                ->select('typeID')
                ->where('typeName', '=', $name)
                ->first();
            Cache::put($cname, $id->typeID, 86400);
            return $id->typeID;
        }
    }

    public static function ReprocessOreByTypeId(int $typeId, int $quantity, float $refining_rate = 0.9) :array
    {
        $ore = self::getMaterialInfo($typeId);
        $p_size = $ore->portionSize;
        $r_count = intval($quantity / $p_size);
        $r_rest = $quantity % $p_size;
        $result = [];
        if ($ore->CategoryId == 25) {
            $rep = self::getReprocessData($typeId);
            foreach ($rep as $r) {
                $result[$r->materialTypeID] = ($r->quantity * $refining_rate) * $r_count;
            }
            if ($r_rest) {
                $result[$typeId] = $r_rest;
            }
        } else {
            $result[$typeId] = $r_count+$r_rest;
        }
        return $result;
    }

    public static function isReprocessable(int $typeId): bool
    {
        $data = DB::table('invTypes as it')
            ->select('it.typeName', 'ig.categoryId')
            ->join('invGroups as ig', 'it.groupID', 'ig.groupID')
            ->where('it.typeID', $typeId)
            ->first();
        if($data->CategoryId == 25) {
            return true;
        } else {
            return false;
        }
    }

}