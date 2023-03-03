<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Models\TaxData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MiningTaxSettings extends Model
{
    public $timestamps = true;

    protected $table = 'mining_tax_settings';
}