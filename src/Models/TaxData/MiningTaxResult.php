<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Models\TaxData;

/**
 * Class MiningTaxResult
 */
class MiningTaxResult
{
    /**
     * @var int
     */
    public $year;

    /**
     * @var int
     */
    public $month;

    /**
     * @var OreType
     */
    public $oreTypes = [];

    /**
     * @var CharacterData
     */
    public $characterData = [];

    /**
     * @param int $month
     * @param int $year
     */
    public function __construct(int $month, int $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    /**
     * @param OreType $ore_Type
     * @return void
     */
    public function addOre(OreType $ore_Type): void
    {
        if (!$this->hasOreType($ore_Type->id)) {
            $this->oreTypes[$ore_Type->id] = $ore_Type;
        }
    }

    /**
     * @param int $oreId
     * @return OreType|null
     */
    public function getOreByTypeId(int $oreId): ?OreType
    {
        if (!$this->hasOreType($oreId)) {
            return null;
        }

        return $this->oreTypes[$oreId];
    }

    /**
     * @param int $oreId
     * @return bool
     */
    public function hasOreType(int $oreId): bool
    {
        return array_key_exists($oreId, $this->oreTypes);
    }

    /**
     * @param CharacterData $characterData
     * @return void
     */
    public function addCharacterData(CharacterData $characterData): void
    {
        if(!$this->hasCharacterData($characterData->characterId)) {
            $this->characterData[$characterData->characterId] = $characterData;
        }
    }

    /**
     * @param int $characterId
     * @return bool
     */
    public function hasCharacterData(int $characterId): bool
    {
        return array_key_exists($characterId, $this->characterData);
    }

    /**
     * @param int $characterId
     * @return CharacterData|null
     */
    public function getCharacterDataById(int $characterId): ?CharacterData
    {

        if (!$this->hasCharacterData($characterId)) {
            return null;
        }

        return $this->characterData[$characterId];
    }
}