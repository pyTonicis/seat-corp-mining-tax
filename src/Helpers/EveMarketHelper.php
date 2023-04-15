<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class EveMarketHelper
{
    public static function getItemPriceById(int $id) :int
    {
        $caching = "ep_" .$id;
        if(Cache::has($caching)) {
            return Cache::get($caching);
        } else {
            $data = DB::table('market_prices')
                ->select('average_price')
                ->where('type_id', '=', $id)
                ->first();
            Cache::put($caching, $data->average_price, 3600);
            return $data->average_price;
        }
    }
}