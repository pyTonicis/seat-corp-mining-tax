<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Services;

use DateTime;
use pyTonicis\Seat\SeatCorpMiningTax\Helpers\CharacterHelper;
use pyTonicis\Seat\SeatCorpMiningTax\Helpers\EveJaniceHelper;
use pyTonicis\Seat\SeatCorpMiningTax\Helpers\EveMarketHelper;
use pyTonicis\Seat\SeatCorpMiningTax\Models\Mining\EventMining;
use pyTonicis\Seat\SeatCorpMiningTax\Models\TaxData\CharacterData;
use pyTonicis\Seat\SeatCorpMiningTax\Models\TaxData\CharacterMiningRecord;
use pyTonicis\Seat\SeatCorpMiningTax\Models\TaxData\MiningTaxResult;
use pyTonicis\Seat\SeatCorpMiningTax\Models\TaxData\OreType;
use pyTonicis\Seat\SeatCorpMiningTax\Services\Reprocessing;
use pyTonicis\Seat\SeatCorpMiningTax\Services\MiningEvents;
use Illuminate\Support\Facades\DB;


/**
 * Class MiningTaxService
 */
class MiningTaxService
{
    /**
     * @param int $corpId
     * @param int $month
     * @param int $year
     * @return mixed
     */
    private function getMiningResultsFromDb(int $corpId, int $month, int $year)
    {

        return DB::table('character_minings as cm')
            ->select(
                'cm.character_id',
                'cm.quantity',
                'cm.type_id',
                'cm.date',
                'cm.time',
                'cm.solar_system_id',
                'it.typeName',
                'it.groupId'
            )
            ->join('corporation_members as cmem', 'cm.character_id', '=', 'cmem.character_id')
            ->join('market_prices as mp', 'cm.type_id', 'mp.type_id')
            ->join('invTypes as it', 'cm.type_id', '=', 'it.typeID')
            ->where('cmem.corporation_id', '=', $corpId)
            ->where('cm.month', '=', $month)
            ->where('cm.year', '=', $year)
            ->get();
    }

    private function checkIfCorpMoon(int $character_id, int $type_id, int $system_id, string $date): bool
    {
        $m_date = $date . " 00:00:00";
        $result = DB::table('corporation_industry_mining_observer_data as d')
            ->select('*')
            ->join('universe_structures as u', 'd.observer_id', '=', 'u.structure_id')
            ->where('d.last_updated', '=', $m_date)
            ->where('d.character_id', '=', $character_id)
            ->where('d.type_id', '=', $type_id)
            ->where('u.solar_system_id', '=', $system_id)
            ->first();
        if(!is_null($result)) {
            return true;
        } else {
            return false;
        }
    }

    public function createMiningTaxResult(int $corpId, int $month, int $year): MiningTaxResult
    {
        $miningResult = new MiningTaxResult($month, $year);
        $miningEventResult = new EventMining($month, $year);
        $eventService = new MiningEvents();
        $settingService = new SettingService();
        $settings = $settingService->getAll();

        foreach ($this->getMiningResultsFromDb($corpId, $month, $year) as $data) {

            $mainCharacterData = CharacterHelper::getMainCharacterCharacter($data->character_id);

            if (!$miningResult->hasOreType($data->type_id)) {

                $ore = new OreType();
                $ore->id = $data->type_id;
                $ore->name = $data->typeName;
                $ore->price = 0;

                $miningResult->addOre($ore);
            }

            if (!$miningResult->hasCharacterData($mainCharacterData->main_character_id)) {

                $charData = new CharacterData(
                    $mainCharacterData->main_character_id,
                    $mainCharacterData->name
                );

                $miningResult->addCharacterData($charData);
            } else {
                $charData = $miningResult->getCharacterDataById($mainCharacterData->main_character_id);
            }

            $charData->addCharacterMining(new CharacterMiningRecord(
                $data->type_id,
                $data->quantity
            ));

            $charData->addQuantity($data->quantity);

            $material_info = Reprocessing::getMaterialInfo($data->type_id);
            $volume = $material_info->volume * $data->quantity;
            $invGroup = $material_info->groupID;

            $charData->addVolume($volume);

            /*
             *  Calculate Reprocessed Ore Price
             */

                foreach (Reprocessing::ReprocessOreByTypeId($data->type_id, $data->quantity, (float)($settings['ore_refining_rate'] / 100)) as $key => $value) {

                    if ($settings['ore_valuation_price'] == 'Ore Price') {
                        if ($settings['price_provider'] == 'Eve Market')
                            $price = EveMarketHelper::getItemPriceById($data->type_id) * $data->quantity;
                        else
                            $price = EveJaniceHelper::getItemPriceByTypeId($data->type_id) * $data->quantity;
                    } else {
                        if ($settings['price_provider'] == 'Eve Market')
                            $price = EveMarketHelper::getItemPriceById($key) * $value;
                        else
                            $price = EveJaniceHelper::getItemPriceByTypeId($key) * $value;
                    }
                    $charData->addToPriceSummary($price);

                    switch ($invGroup) {
                        case 465:
                            if ($settings['taxes_ice'] == "true")
                                $charData->addTax($price * ($settings['ice_rate'] / 100));
                            break;
                        case 711:
                            if ($settings['taxes_gas'] == "true")
                                $charData->addTax($price * ($settings['gas_rate'] / 100));
                            break;
                        case 1884:
                            if ($settings['taxes_moon'] == "true") {
                                $charData->addTax($price * ($settings['r4_rate'] / 100));
                            } elseif ($settings['taxes_corp_moon'] == "true") {
                                if ($this->checkIfCorpMoon($data->character_id, $data->type_id, $data->solar_system_id, $data->date))
                                    $charData->addTax($price * ($settings['r4_rate'] / 100));
                            }
                            break;
                        case 1920:
                            if ($settings['taxes_moon'] == "true") {
                                $charData->addTax($price * ($settings['r8_rate'] / 100));
                            } elseif ($settings['taxes_corp_moon'] == "true") {
                                if ($this->checkIfCorpMoon($data->character_id, $data->type_id, $data->solar_system_id, $data->date))
                                    $charData->addTax($price * ($settings['r8_rate'] / 100));
                            }
                            break;
                        case 1921:
                            if ($settings['taxes_moon'] == "true") {
                                $charData->addTax($price * ($settings['r16_rate'] / 100));
                            } elseif ($settings['taxes_corp_moon'] == "true") {
                                if ($this->checkIfCorpMoon($data->character_id, $data->type_id, $data->solar_system_id, $data->date))
                                    $charData->addTax($price * ($settings['r16_rate'] / 100));
                            }
                            break;
                        case 1922:
                            if ($settings['taxes_moon'] == "true") {
                                $charData->addTax($price * ($settings['r32_rate'] / 100));
                            } elseif ($settings['taxes_corp_moon'] == "true") {
                                if ($this->checkIfCorpMoon($data->character_id, $data->type_id, $data->solar_system_id, $data->date))
                                    $charData->addTax($price * ($settings['r32_rate'] / 100));
                            }
                            break;
                        case 1923:
                            if ($settings['taxes_moon'] == "true") {
                                $charData->addTax($price * ($settings['r64_rate'] / 100));
                            } elseif ($settings['taxes_corp_moon'] == "true") {
                                if ($this->checkIfCorpMoon($data->character_id, $data->type_id, $data->solar_system_id, $data->date))
                                    $charData->addTax($price * ($settings['r64_rate'] / 100));
                            }
                            break;
                        case 1996:
                            if ($settings['taxes_abyssal'] == "true")
                                $charData->addTax($price * ($settings['abyssal_rate'] / 100));
                            break;
                        default:
                            if ($settings['taxes_ore'] == "true")
                                $charData->addTax($price * ($settings['ore_rate'] / 100));
                            break;
                    }
                }
            }
        /*
         *  Remove Tax for Events from Tax Wallet
         */
        $miningEventResult = $eventService->createEventMiningTax($month, $year);

        foreach ($miningEventResult as $eventData) {
            if ($miningResult->hasCharacterData(CharacterHelper::getCharacterIdByName($eventData->characterId))) {

                if ($miningResult->characterData[$eventData->characterId]->hasCharacterMining($eventData->type_id)) {
                    foreach (Reprocessing::ReprocessOreByTypeId($eventData->type_id, $eventData->quantity, (float)($eventData->event_tax / 100)) as $key => $value) {

                        if ($settings['ore_valuation_price'] == 'Ore Price') {
                            if ($settings['price_provider'] == 'Eve Market')
                                $price = EveMarketHelper::getItemPriceById($eventData->type_id) * $eventData->quantity;
                            else
                                $price = EveJaniceHelper::getItemPriceByTypeId($eventData->type_id) * $eventData->quantity;
                        } else {
                            if ($settings['price_provider'] == 'Eve Market')
                                $price = EveMarketHelper::getItemPriceById($key) * $value;
                            else
                                $price = EveJaniceHelper::getItemPriceByTypeId($key) * $value;
                        }
                        $miningResult->characterData[$eventData->characterId]->delTax($price);
                    }
                }
            }
        }
        return $miningResult;
    }
}