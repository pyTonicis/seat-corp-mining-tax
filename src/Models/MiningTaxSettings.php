<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class MiningTaxSettings extends Model
{
    protected $table = 'mining_tax_settings';

    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $guarded = [];
}