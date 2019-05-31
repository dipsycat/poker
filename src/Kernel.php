<?php

namespace App;

use App\Service\CardCalculate;

class Kernel
{
    public function start($board, $players) {





        $cards = [
            new Card('9s', false),
            new Card('10s', false),
            new Card('Js', false),
            new Card('Ks', false),

        ];

        $card1 = new Card('As', true);
        $card2 = new Card('2s', true);
        array_push($cards, $card1, $card2);

        $calculate = new \App\Service\CardCalculate();
        $calculate->calculate($cards);






        //index.php --board=7dAcJc4d --p1=7sAh --p2=JsJd --p3=KsQs
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
