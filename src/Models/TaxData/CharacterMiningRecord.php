<?php

namespace H4zz4rdDev\Seat\SeatCorpMiningTax\Models\TaxData;

/**
 * Class CharacterMiningRecord
 */
class CharacterMiningRecord
{
    /**
     * @var int
     */
    public $oreTypeId;

    /**
     * @var int
     */
    public $quantity;

    public function __construct(int $oreTypeId, int $quantity)
    {
        $this->oreTypeId = $oreTypeId;
        $this->quantity = $quantity;
    }

    /**
     * @param int $quantity
     * @return void
     */
    public function add(int $quantity) : void {
        $this->quantity += $quantity;
    }
}