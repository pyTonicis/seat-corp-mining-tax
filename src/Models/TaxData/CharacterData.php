<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Models\TaxData;

/**
 * Class CharacterData
 */
class CharacterData
{
    /**
     * @var int
     */
    public $characterId;

    /**
     * @var string
     */
    public $characterName;

    /**
     * @var int
     */
    public $tax;
    /**
     * @var int
     */
    public $tax2;
    /**
     * @var int
     */
    public $event_tax;
    /**
     * @var int
     */
    public $volume;

    /**
     * @var int
     */
    public $quantity;

    /**
     * @var int
     */
    public $priceSummary;

    /**
     * @var array
     */
    public $miningRecords = [];

    /**
     *
     * Constructor
     *
     * @param int $characterId
     * @param string $characterName
     */
    public function __construct(int $characterId, string $characterName)
    {
        $this->characterId = $characterId;
        $this->characterName = $characterName;
        $this->priceSummary = 0;
        $this->tax = 0;
        $this->event_tax = 0;
    }

    /**
     * @param int $oreTypeId
     * @return bool
     */
    public function hasCharacterMining(int $oreTypeId): bool
    {
        return array_key_exists($oreTypeId, $this->miningRecords);
    }

    /**
     * @param int $oreTypeId
     * @return CharacterMiningRecord|null
     */
    public function getCharacterMiningById(int $oreTypeId): ?CharacterMiningRecord
    {
        if (!$this->hasCharacterMining($oreTypeId)) {
            return null;
        }

        return $this->miningRecords[$oreTypeId];
    }

    public function addCharacterMining(CharacterMiningRecord $characterMiningRecord)
    {
        if (!$this->hasCharacterMining($characterMiningRecord->oreTypeId)) {
            $this->miningRecords[$characterMiningRecord->oreTypeId] = $characterMiningRecord;
        } else {
            $this->getCharacterMiningById($characterMiningRecord->oreTypeId)->add($characterMiningRecord->quantity);
        }
    }

    /**
     * @param int $value
     * @return void
     */
    public function addToPriceSummary(int $value)
    {
        $this->priceSummary += $value;
    }

    /**
     * @param int $taxValue
     * @return void
     */
    public function addTax(int $taxValue) {
        $this->tax += $taxValue;
    }

    public function addEventTax(int $taxValue) {
        $this->event_tax += $taxValue;
    }

    public function addVolume(int $vol) {
        $this->volume += $vol;
    }

    public function addQuantity(int $q) {
        $this->quantity += $q;
    }
}