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
        if(!$settings['mining_tax_calculation'] == 'combined') {
            $taxes = DB::table('corp_mining_tax')
                ->select('*')
                ->where('month', '=', $month)
                ->where('year', '=', $year)
                ->get();
            foreach ($taxes as $t) {

                    if ($t->tax >= $settings['contract_min']) {
                        $c_title = $settings['contract_tag'] . " " . $t->year . "-" . $t->month . " (" . $this->generate_string($this->permitted_chars) . ")";
                        DB::table('corp_mining_tax_contracts')
                            ->updateOrInsert(['character_id' => $t->character_id, 'month' => $t->month, 'year' => $t->year, 'tax' => $t->tax],
                                ['contractId' => 0, 'contractIssuer' => CharacterHelper::getCharacterIdByName($settings['contract_issuer']), 'contractTitle' => $c_title,
                                    'contractData' => "None", 'contractStatus' => 1, 'character_name' => CharacterHelper::getCharacterName($t->character_id), 'corporation_id' => $t->corporation_id]);
                    }
            }
        } else {
            DB::statement("SET SQL_MODE=''");
            $taxes = DB::table('corp_mining_tax')
                ->selectRaw('sum(tax) as tax, sum(event_tax) as event_tax, character_id, main_character_id, year, month, corporation_id')
                ->where('month', '=', $month)
                ->where('year', '=', $year)
                ->orderBy('main_character_id')
                ->groupBy('main_character_id')
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
            ->where('contractId', '=', (int)$contract_id)
            ->update(['contractStatus' => (int)$status]);
    }

    public function searchContractId(string $title) :int
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

    public function setContractIds(int $corp_id)
    {
        $contracts = DB::table('corp_mining_tax_contracts')
            ->select('*')
            ->where('corporation_id', '=', $corp_id)
            ->get();
        foreach ($contracts as $contract) {
            if ($contract->contractId == 0) {
                $contract_id = $this->searchContractId($contract->contractTitle);
                if ($contract_id != 0) {
                    DB::table('corp_mining_tax_contracts')
                        ->where('id', '=', (int)$contract->id)
                        ->update(['contractId' => $contract_id]);
                }
            }
        }
    }

    public function updateContractStatus(int $corp_id)
    {
        $contracts = DB::table('corp_mining_tax_contracts')
            ->select('*')
            ->where('contractStatus', '!=', 0)
            ->where('contractId', '!=', 0)
            ->get();
        foreach ($contracts as $contract) {
            $contract_status = $this->getContractStatus($contract->contractId);
            if ($contract_status == 'finished') {
                $this->setTaxContractStatus($contract->contractId, 3);
            } elseif($contract_status == 'outstanding') {
                $this->setTaxContractStatus($contract->contractId, 4);
            } elseif($contract_status == 'in_progress') {
                $this->setTaxContractStatus($contract->contractId, 2);
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