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
        $total_units = 0;
        $total_volume = 0;
        $total_price = 0;
        $total_tax = 0;
        $minings = DB::table('corp_mining_tax')
            ->select('*')
            ->get();
        foreach ($minings as $mining) {
            $total_units += $mining->quantity;
            $total_volume += $mining->volume;
            $total_price += $mining->price;
            $total_tax += $mining->tax;
        }
        $top_ten_miners = DB::table('corp_mining_tax')
            ->select('main_character_id', 'quantity', 'volume', 'price')
            ->join('character_infos as c', 'main_character_id', '=', 'c.character_id')
            ->groupBy('main_character_id')
            ->orderBy('volume', 'desc')
            ->limit(5)
            ->get();
        $total_members = DB::table('corp_mining_tax')
            ->select('main_character_id')
            ->orderBy('main_character_id')
            ->count();
        DB::statement("SET SQL_MODE=''");
        $events = DB::table('corp_mining_tax_event_minings')
            ->selectRaw('sum(refined_price) as price')
            ->first();
        $total_event_price = $events->price;
        return view('corpminingtax::corpminingstatistics', [
            'total_quantity' => $total_units,
            'total_volume' => $total_volume,
            'total_price' => $total_price,
            'total_tax' => $total_tax,
            'total_members' => $total_members,
            'top_ten_miners' => $top_ten_miners,
            'total_event_price' => $total_event_price,
        ]);
    }
}