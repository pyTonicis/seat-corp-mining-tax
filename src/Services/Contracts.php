<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Services;

use pyTonicis\Seat\SeatCorpMiningTax\Helpers\CharacterHelper;
use Illuminate\Support\Facades\DB;

class Contracts
{
    private $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public function createTaxContracts(int $corp_id, int $month, int $year)
    {
        $settingService = new SettingService();
        $settings = $settingService->getAll();
        if($corp_id) {
            $taxes = DB::table('corp_mining_tax')
                ->select('*')
                ->where('month', '=', $month)
                ->where('year', '=', $year)
                ->get();
            foreach ($taxes as $tax) {
                if($tax>tax != 0) {
                    $c_title = $settings['contract_tag'] . " ". $tax->year . "-". $tax->month. " ". $this->generate_string($this->permitted_chars);
                    DB::table('corp_mining_tax_contracts')
                        ->updateOrInsert(['character_id' => $tax->main_character_id, 'month' => $tax->month, 'year' => $tax->year, 'tax' => $tax->tax],
                        ['contractId' => 0, 'contractIssuer' => CharacterHelper::getCharacterIdByName($settings['contract_issuer']), 'contractTitle' => $c_title, 'contractData' => "None", 'contractStatus' => 1]);
                }
            }
        }
    }

    private function generate_string($input, $strength = 10) {

        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
        return $random_string;

    }


}