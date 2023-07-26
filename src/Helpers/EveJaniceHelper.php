<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Helpers;

use Illuminate\Support\Facades\Cache;
use pyTonicis\Seat\SeatCorpMiningTax\Services\SettingService;

class EveJaniceHelper
{
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
        return self::getAllItemPrices($typeId)["immediatePrices"]["buyPrice"];
    }

    /**
     * @param int $itemId
     * @return mixed|null
     */
    public static function doCall(int $itemId)
    {

        $settingService = new SettingService();
        $settings = $settingService->getAll();
        $url = sprintf("https://janice.e-351.com/api/rest/v2/pricer/%d?market=2", $itemId);
        $opts = array(
            'http' => array(
                'method' => "GET",
                'header' =>
                    "X-ApiKey: " . $settings['price_provider_key'] . "\r\n" .
                    "accept:application/json\r\n"
            )
        );
        $context = stream_context_create($opts);
        $data = file_get_contents($url, false, $context);

        if ($data === false) {
            return null;
        }

        return json_decode($data, true);

    }

}