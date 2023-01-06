<?php

/*
This file is part of SeAT

Copyright (C) 2015 to 2020  Leon Jacobs

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

namespace pyTonicis\Seat\SeatCorpMiningTax\Helpers;

use Illuminate\Support\Facades\DB;

/*
 * Class CharacterHelper
 *
 * @package H4zz4rdDev\Seat\SeatCorpMiningTax\Helpers
 */
class CharacterHelper {

    public static function getMainCharacterCharacter (int $character_id) : object {

        return DB::table('refresh_tokens as rt')
            ->join('users as u', 'rt.user_id', '=', 'u.id')
            ->where('rt.character_id', '=', $character_id)
            ->first();
    }
}
