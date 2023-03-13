<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Models\TaxData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MiningTaxSettings extends Model
{
    protected $table = 'mining_tax_settings';

    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $guarded = [];
}