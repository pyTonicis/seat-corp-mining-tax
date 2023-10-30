<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Helpers;

use Illuminate\Support\Facades\DB;

/**
 * Class CharacterHelper
 */
class CharacterHelper {

    /**
     * return the MainCharacter for any linked characters
     * @param int $character_id
     * @return mixed
     */
    public static function getMainCharacterCharacter (int $character_id) : object {

        return DB::table('refresh_tokens as rt')
            ->join('users as u', 'rt.user_id', '=', 'u.id')
            ->where('rt.character_id', '=', $character_id)
            ->first();
    }

    /**
     * return a list of MainCharacters
     * @return mixed
     */
    public static function getMainCharacters() {

        DB::statement("SET SQL_MODE=''");
        return DB::table('refresh_tokens as t')
            ->select('u.main_character_id as id', 'u.name')
            ->join('users as u', 't.user_id', '=', 'u.id')
            ->where('u.active', '=', 1)
            ->groupBy('u.id')
            ->get();
    }

    /**
     * returns the character name by a given character id
     * @param int $character_id
     * @return string
     */
    public static function getCharacterName(int $character_id) {

        $data = DB::table('character_infos')
            ->select('name')
            ->where('character_id', '=', $character_id)
            ->first();
        if (!is_null($data))
            return $data->name;
        else
            return "unknown";
    }

    /**
     * returns the character id by a given character name
     * @param string $name
     * @return mixed
     */
    public static function getCharacterIdByName(string $name) {
        $data = DB::table('character_infos')
            ->select('character_id', 'name')
            ->where('name', '=', $name)
            ->first();
        return $data->character_id;
    }

    /**
     * return a list of linked characters (in seat) by a given character id
     * @param int $character_id
     * @return mixed
     */
    public static function getLinkedCharacters(int $character_id)
    {
       $result = DB::table('refresh_tokens')
           ->select('character_id', 'user_id')
           ->where('character_id', $character_id)
           ->first();
       if($result->user_id) {
           $data = DB::table('refresh_tokens')
               ->select('character_id')
               ->where('user_id', $result->user_id)
               ->pluck('character_id');
       }
       return $data;
    }
}
