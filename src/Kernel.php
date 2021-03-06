<?php

namespace App;

use App\Service\CardCalculate;
use App\Service\ParseArgs;

class Kernel
{
    /**
     * @param string $board
     * @param array $players
     * @throws Exception\NotCorrectCardException
     */
    public function start(string $board, array $players): void
    {
        $result = [];
        $boardCards = ParseArgs::parseBoard($board);
        $calculate = new CardCalculate();
        /** @var Player $player */
        foreach ($players as $player) {
            $cards = $boardCards;
            array_push($cards, $player->getCard1(), $player->getCard2());
            $cardPrint = $calculate->calculate($cards);
            $result[$cardPrint->getWeight()] = $player->getName() . ' ' . $cardPrint->getTextWeight() . ' ' . $cardPrint->getOutput();
        }

        for ($i = 10; $i >= 1; $i--) {
            if (isset($result[$i])) {
                echo $result[$i] . "\n";
            }
        }
    }
}
