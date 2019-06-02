<?php

namespace App\Service;

use App\Card;
use App\Player;
use App\Exception\NotCorrectCardException;

class ParseArgs
{
    const BOARD_PARAM = 'board:';
    const BOARD_KEY = 'board';

    /**
     * @param array $args
     * @return array
     * @throws NotCorrectCardException
     */
    public static function parsePlayers(array $args): array
    {
        $players = [];
        foreach ($args as $arg) {
            $matches = [];
            if (preg_match("/^--p\d+=\w{4}$/", $arg, $matches)) {
                $params = explode("=", $matches[0]);
                $playerName = mb_substr($params[0], 2);
                $card1 = mb_substr($params[1], 0, 2);
                $card2 = mb_substr($params[1], 2, 2);
                $players[] = new Player($playerName, new Card($card1, true), new Card($card2, true));
            }
        }
        return $players;
    }

    /**
     * @param string $board
     *
     * @return Card[]
     * @throws NotCorrectCardException
     */
    public static function parseBoard(string $board): array
    {
        $matches = [];
        preg_match_all("/([2-9]|10|[JQKA])[dsch]+/", $board, $matches);
        $boardCards = [];
        foreach ($matches[0] as $match) {
            $boardCards[] = new Card($match, false);
        }
        return $boardCards;
    }
}
