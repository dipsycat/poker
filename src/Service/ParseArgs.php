<?php

namespace App\Service;

use App\Card;
use App\Player;

class ParseArgs
{

    const BOARD_PARAM = 'board:';
    const BOARD_KEY = 'board';

    public static function parsePlayers($args)
    {
        $players = [];
        foreach($args as $arg) {
            $matches = [];
            if(preg_match("/^--p\d+=\w{4}$/", $arg, $matches)) {
                $params = explode ("=", $matches[0]);
                $playerName = mb_substr($params[0], 2);
                //$players[$playerName] = $params[1];

                $card1 = mb_substr($params[1], 0, 2);
                $card2 = mb_substr($params[1], 2, 2);
                $players[] = new Player($playerName, new Card($card1, true), new Card($card2, true));
            }
        }
        return $players;
    }

    public static function parseBoard()
    {

    }

}