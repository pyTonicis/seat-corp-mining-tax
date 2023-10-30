<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class EveMarketHelper
{
    /**
     * get the price for a given type_id
     * @param int $type_id
     * @return int
     */
    public static function getItemPriceById(int $type_id) :int
    {
        $caching = "ep_" .$type_id;
        if(Cache::has($caching)) {
            return Cache::get($caching);
        } else {
            $data = DB::table('market_prices')
                ->select('average_price')
                ->where('type_id', '=', $type_id)
                ->first();
            Cache::put($caching, $data->average_price, 3600);
            return $data->average_price;
        }
    }
}