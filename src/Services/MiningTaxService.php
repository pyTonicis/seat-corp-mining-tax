<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Services;

use pyTonicis\Seat\SeatCorpMiningTax\Helpers\CharacterHelper;
use pyTonicis\Seat\SeatCorpMiningTax\Helpers\EvePraisalHelper;
use pyTonicis\Seat\SeatCorpMiningTax\Models\TaxData\CharacterData;
use pyTonicis\Seat\SeatCorpMiningTax\Models\TaxData\CharacterMiningRecord;
use pyTonicis\Seat\SeatCorpMiningTax\Models\TaxData\MiningTaxResult;
use pyTonicis\Seat\SeatCorpMiningTax\Models\TaxData\OreType;
use pyTonicis\Seat\SeatCorpMiningTax\Services\Reprocessing;
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

    private function getItemPriceById(int $id) :int
    {
        $data = DB::table('market_prices')
            ->select('average_price')
            ->where('type_id', '=', $id)
            ->first();
        return $data->average_price;
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
        $settings = new SettingService();

        foreach ($this->getMiningResultsFromDb($corpId, $month, $year) as $data) {

            $mainCharacterData = CharacterHelper::getMainCharacterCharacter($data->character_id);

            if (!$miningResult->hasOreType($data->type_id)) {

                $ore = new OreType();
                $ore->id = $data->type_id;
                $ore->name = $data->typeName;
                $ore->price = EvePraisalHelper::getItemPriceByTypeId($data->type_id);

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
            $volume = Reprocessing::getMaterialInfo($data->type_id)->volume * $data->quantity;
            $invGroup = Reprocessing::getMaterialInfo($data->type_id)->groupID;
            $charData->addVolume($volume);

            foreach(Reprocessing::ReprocessOreByTypeId($data->type_id, $data->quantity, (float)($settings->getValue('ore_refining_rate') / 100)) as $key => $value)
            {
                if($settings->getValue('price_provider') == 'Eve Market')
                    $price = $this->getItemPriceById($key) * $value;
                else
                    $price = EvePraisalHelper::getItemPriceByTypeId($key) * $value;
                $charData->addToPriceSummary($price * (float)($settings->getValue('ore_refining_rate') / 100));
                switch($invGroup) {
                    case 465:
                        if ($settings->getValue('taxes_ice') == "true")
                            $charData->addTax($price * ($settings->getValue('ice_rate') / 100));
                        break;
                    case 711:
                        if ($settings->getValue('taxes_gas') == "true")
                            $charData->addTax($price * ($settings->getValue('gas_rate') / 100));
                        break;
                    case 1884:
                        if ($settings->getValue('taxes_moon') == "true") {
                            $charData->addTax($price * ($settings->getValue('r4_rate') / 100));
                        } elseif ($settings->getValue('taxes_corp_moon') == "true") {
                            if($this->checkIfCorpMoon($data->character_id, $data->type_id, $data->solar_system_id, $data->date))
                                $charData->addTax($price * ($settings->getValue('r4_rate') / 100));
                        }
                        break;
                    case 1920:
                        if ($settings->getValue('taxes_moon') == "true") {
                            $charData->addTax($price * ($settings->getValue('r8_rate') / 100));
                        } elseif ($settings->getValue('taxes_corp_moon') == "true") {
                            if($this->checkIfCorpMoon($data->character_id, $data->type_id, $data->solar_system_id, $data->date))
                                $charData->addTax($price * ($settings->getValue('r8_rate') / 100));
                        }
                        break;
                    case 1921:
                        if ($settings->getValue('taxes_moon') == "true") {
                            $charData->addTax($price * ($settings->getValue('r16_rate') / 100));
                        } elseif ($settings->getValue('taxes_corp_moon') == "true") {
                            if($this->checkIfCorpMoon($data->character_id, $data->type_id, $data->solar_system_id, $data->date))
                                $charData->addTax($price * ($settings->getValue('r16_rate') / 100));
                        }
                        break;
                    case 1922:
                        if ($settings->getValue('taxes_moon') == "true") {
                            $charData->addTax($price * ($settings->getValue('r32_rate') / 100));
                        } elseif ($settings->getValue('taxes_corp_moon') == "true") {
                            if($this->checkIfCorpMoon($data->character_id, $data->type_id, $data->solar_system_id, $data->date))
                                $charData->addTax($price * ($settings->getValue('r32_rate') / 100));
                        }
                        break;
                    case 1923:
                        if ($settings->getValue('taxes_moon') == "true") {
                            $charData->addTax($price * ($settings->getValue('r64_rate') / 100));
                        } elseif ($settings->getValue('taxes_corp_moon') == "true") {
                            if($this->checkIfCorpMoon($data->character_id, $data->type_id, $data->solar_system_id, $data->date))
                                $charData->addTax($price * ($settings->getValue('r64_rate') / 100));
                        }
                        break;
                    case 1996:
                        if ($settings->getValue('taxes_abyssal') == "true")
                            $charData->addTax($price * ($settings->getValue('abyssal_rate') / 100));
                        break;
                }
            }
        }
        return $miningResult;
    }
}