<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Http\Controllers;

use Seat\Web\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js;

class CorpMiningStatistics extends Controller
{
    public function getHome()
    {
        $act_m = (date('m', time()));
        $act_y = (date('Y', time()) -1);
        $minings = DB::table('corp_mining_tax')
            ->select('*')
            ->where('month', '>=', 'month')
            ->where('year', '>=', 'year')
            ->get();
        foreach ($minings as $mining) {
            $total_units += $mining->quantity;
            $total_volume += $mining->volume;
            $total_price += $mining->price;
            $total_tax += $mining->tax;
        }
        $total_members = DB::table('corp_mining_tax')
            ->select('main_character_id')
            ->where('month', '>=', $act_m)
            ->where('year', '>=', $act_y)
            ->orderBy('main_character_id')
            ->count();
        return view('corpminingtax::corpminingstatistics', [
            'total_quantity' => $total_units,
            'total_volume' => $total_volume,
            'total_price' => $total_price,
            'total_tax' => $total_tax,
            'total_members' => $total_members,
        ]);
    }
}