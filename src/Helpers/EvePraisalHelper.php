<?php

/*
This file is part of SeAT

Copyright (C) 2015 to 2020  Leon Jacobs

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

namespace H4zz4rdDev\Seat\SeatCorpMiningTax\Helpers;

use Illuminate\Support\Facades\Cache;

class EvePraisalHelper
{
    private $priceData;

    /**
     * @param int $typeId
     * @return mixed|null
     */
    public static function getAllItemPrices(int $typeId)
    {

        $cacheId = "tax_" . $typeId;

        if (Cache::has($cacheId)) {
            $prices = Cache::get($cacheId);
        } else {
            $prices = self::doCall($typeId);
            Cache::put($cacheId, $prices, 3600);
        }

        return $prices;
    }

    /**
     * @param int $typeId
     * @return int
     */
    public static function getItemPriceByTypeId(int $typeId): int
    {
        return self::getAllItemPrices($typeId)["summaries"][0]["prices"]["buy"]["percentile"];
    }

    /**
     * @param string $itemTypeId
     * @return mixed|null
     */
    public static function doCall(string $itemTypeId)
    {

        $url = sprintf("https://evepraisal.com/item/%d.json", $itemTypeId);
        $data = @file_get_contents($url);

        if ($data === false) {
            return null;
        }

        return json_decode($data, true);

    }

}
