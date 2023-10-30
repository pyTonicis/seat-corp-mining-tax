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
            foreach ($taxes as $t) {

                    if ($t->tax >= $settings['contract_min']) {
                        $c_title = $settings['contract_tag'] . " " . $t->year . "-" . $t->month . " (" . $this->generate_string($this->permitted_chars) . ")";
                        DB::table('corp_mining_tax_contracts')
                            ->updateOrInsert(['character_id' => $t->main_character_id, 'month' => $t->month, 'year' => $t->year, 'tax' => $t->tax],
                                ['contractId' => 0, 'contractIssuer' => CharacterHelper::getCharacterIdByName($settings['contract_issuer']), 'contractTitle' => $c_title,
                                    'contractData' => "None", 'contractStatus' => 1, 'character_name' => CharacterHelper::getCharacterName($t->main_character_id), 'corporation_id' => $t->corporation_id]);
                    }
            }
        }
    }

    public function setTaxContractStatus(int $contract_id, int $status)
    {
        DB::table('corp_mining_tax_contracts')
            ->update(['contractStatus' => $status])
            ->where('contractId', '=', $contract_id);
    }

    public function searchContractDetails(string $title) :int
    {
        $contract = DB::table('contract_details')
            ->select('contract_id', 'title')
            ->where('title', 'LIKE', "%". $title ."%")
            ->first();
        if (!is_null($contract)) {
            return $contract->contract_id;
        } else {
            return 0;
        }
    }

    public function getContractStatus(int $contract_id)
    {
        $contract_status = DB::table('contract_details')
            ->select('status')
            ->where('contract_id', '=', $contract_id)
            ->first();
        return $contract_status->status;
    }

    public function setContractIds()
    {
        $contracts = DB::table('corp_mining_tax_contracts')
            ->select('*')
            ->get();
        foreach ($contracts as $contract) {
            if ($contract->contractId == 0) {
                $contract_id = $this->searchContractDetails($contract->contractTitle);
                if ($contract_id != 0) {
                    DB::table('corp_mining_tax_contracts')
                        ->where('id', '=', (int)$contract->id)
                        ->update(['contractId' => $contract_id]);
                }
            }
        }
    }

    public function updateContractStatus(int $corp_id, int $month, int $year)
    {
        $contracts = DB::table('corp_mining_tax_contracts')
            ->select('*')
            ->where('month', '=', $month)
            ->where('year', '=', $year)
            ->get();
        $con_db = DB::table('contract_details')
            ->whereMonth('date_issued', '=', $month)
            ->whereYear('date_issued', '=', $year)
            ->get();
        foreach ($contracts as $contract) {
            $contract_id = $this->searchContractDetails($contract->contractTitle);
            $contract_status = $this->getContractStatus($contract_id);
            if ($contract_status == 'finished') $this->setTaxContractStatus($contract_id, 3);
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