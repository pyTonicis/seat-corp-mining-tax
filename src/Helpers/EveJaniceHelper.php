<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Helpers;

use Illuminate\Support\Facades\Cache;
use pyTonicis\Seat\SeatCorpMiningTax\Services\SettingService;

/**
 * Class EveJaniceHelper
 */
class EveJaniceHelper
{
    /**
     * get the price by given type_id
     * @param int $typeId
     * @return mixed|null
     */
    public static function getAllItemPrices(int $typeId)
    {
        return self::doCall($typeId);
    }

    /**
     * @param int $typeId
     * @return int
     */
    public static function getItemPriceByTypeId(int $typeId): int
    {
        $cacheId = "market_" . $typeId;

        if (Cache::has($cacheId)) {
            $price = Cache::get($cacheId);
        } else {
            $price = self::getAllItemPrices($typeId)["immediatePrices"]["buyPrice"];
            Cache::put($cacheId, $price, 3600);
        }
        return $price;
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