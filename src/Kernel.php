<?php

namespace App;

use App\Service\CardCalculate;

class Kernel
{
    public function start($board, $players)
    {
        $matches = [];
        preg_match_all("/([2-9]|10|[JQKA])[dsch]+/", $board, $matches);
        $boardCards = [];
        foreach($matches[0] as $match) {
            $boardCards[] = new Card($match, false);
        }
        $result = [];

        $calculate = new CardCalculate();
        /** @var Player $player */
        foreach ($players as $player) {
            $cards = $boardCards;
            array_push($cards, $player->getCard1(), $player->getCard2());

            $cardPrint = $calculate->calculate($cards);
            $result[$cardPrint->getWeight()] = $player->getName() . ' ' . $cardPrint->getTextWeight() . ' ' . $cardPrint->getOutput();
        }

        for($i = 10; $i >= 1; $i--) {
            if(isset($result[$i])) {
                echo $result[$i] . "\n";
            }
        }
    }
}
