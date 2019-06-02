<?php

use App\Card;
use PHPUnit\Framework\TestCase;
use App\Service\CardCalculate;

class CardCalculateTest extends TestCase
{
    public function testCalculateRoyalFlush()
    {
        $cards = [
            new Card('10h', false),
            new Card('7s', false),
            new Card('Jh', false),
            new Card('Kh', false),

        ];

        $card1 = new Card('Qh', true);
        $card2 = new Card('Ah', true);
        array_push($cards, $card1, $card2);

        $calculate = new \App\Service\CardCalculate();
        $this->assertEquals($calculate->calculate($cards)->getWeight(), CardCalculate::$weight[CardCalculate::ROYAL_FLUSH]);
        $this->assertEquals($calculate->calculate($cards)->getOutput(), '[10h Jh Qh Kh Ah]');
    }

    public function testCalculateStraightFlush()
    {
        $cards = [
            new Card('10h', false),
            new Card('9h', false),
            new Card('Jh', false),
            new Card('Kh', false),

        ];

        $card1 = new Card('Qh', true);
        $card2 = new Card('As', true);
        array_push($cards, $card1, $card2);

        $calculate = new \App\Service\CardCalculate();
        $this->assertEquals($calculate->calculate($cards)->getWeight(), CardCalculate::$weight[CardCalculate::STRAIGHT_FLUSH]);
        $this->assertEquals($calculate->calculate($cards)->getOutput(), '[9h 10h Jh Qh Kh]');
    }

    public function testCalculateFour()
    {
        $cards = [
            new Card('10h', false),
            new Card('10d', false),
            new Card('10s', false),
            new Card('Ac', false),

        ];

        $card1 = new Card('Qh', true);
        $card2 = new Card('10c', true);
        array_push($cards, $card1, $card2);

        $calculate = new \App\Service\CardCalculate();
        $this->assertEquals($calculate->calculate($cards)->getWeight(), CardCalculate::$weight[CardCalculate::FOUR_OF_A_KIND]);
        $this->assertEquals($calculate->calculate($cards)->getOutput(), '[10h 10d 10s 10c Ac]');
    }

    public function testCalculateFlush()
    {
        $cards = [
            new Card('10h', false),
            new Card('9h', false),
            new Card('7h', false),
            new Card('Ah', false),

        ];

        $card1 = new Card('Qh', true);
        $card2 = new Card('10c', true);
        array_push($cards, $card1, $card2);

        $calculate = new \App\Service\CardCalculate();
        $this->assertEquals($calculate->calculate($cards)->getWeight(), CardCalculate::$weight[CardCalculate::FLUSH]);
        $this->assertEquals($calculate->calculate($cards)->getOutput(), '[7h 9h 10h Qh Ah]');
    }

    public function testCalculateFlush1()
    {
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
        $this->assertEquals($calculate->calculate($cards)->getWeight(), CardCalculate::$weight[CardCalculate::FLUSH]);
        $this->assertEquals($calculate->calculate($cards)->getOutput(), '[9s 10s Js Ks As]');
    }

    public function testCalculateFullHouse()
    {
        $cards = [
            new Card('10h', false),
            new Card('10d', false),
            new Card('10c', false),
            new Card('Ah', false),

        ];

        $card1 = new Card('Ac', true);
        $card2 = new Card('9c', true);
        array_push($cards, $card1, $card2);

        $calculate = new \App\Service\CardCalculate();
        $this->assertEquals($calculate->calculate($cards)->getWeight(), CardCalculate::$weight[CardCalculate::FULL_HOUSE]);
        $this->assertEquals($calculate->calculate($cards)->getOutput(), '[10h 10d 10c Ah Ac]');
    }

    public function testCalculateStraight()
    {
        $cards = [
            new Card('4h', false),
            new Card('5d', false),
            new Card('6c', false),
            new Card('Ah', false),

        ];

        $card1 = new Card('7c', true);
        $card2 = new Card('8c', true);
        array_push($cards, $card1, $card2);

        $calculate = new \App\Service\CardCalculate();
        $this->assertEquals($calculate->calculate($cards)->getWeight(), CardCalculate::$weight[CardCalculate::STRAIGHT]);
        $this->assertEquals($calculate->calculate($cards)->getOutput(), '[4h 5d 6c 7c 8c]');
    }


    public function testCalculateThree()
    {
        $cards = [
            new Card('4h', false),
            new Card('4d', false),
            new Card('4c', false),
            new Card('Ah', false),

        ];

        $card1 = new Card('7c', true);
        $card2 = new Card('8c', true);
        array_push($cards, $card1, $card2);

        $calculate = new \App\Service\CardCalculate();
        $this->assertEquals($calculate->calculate($cards)->getWeight(), CardCalculate::$weight[CardCalculate::THREE_OF_A_KIND]);
        $this->assertEquals($calculate->calculate($cards)->getOutput(), '[4h 4d 4c 8c Ah]');
    }

    public function testCalculateTwoPair()
    {
        $cards = [
            new Card('4h', false),
            new Card('4d', false),
            new Card('5c', false),
            new Card('7h', false),

        ];

        $card1 = new Card('7c', true);
        $card2 = new Card('8c', true);
        array_push($cards, $card1, $card2);

        $calculate = new \App\Service\CardCalculate();
        $this->assertEquals($calculate->calculate($cards)->getWeight(), CardCalculate::$weight[CardCalculate::TWO_PAIR]);
        $this->assertEquals($calculate->calculate($cards)->getOutput(), '[4h 4d 7h 7c 8c]');
    }

    public function testCalculateOnePair()
    {
        $cards = [
            new Card('4h', false),
            new Card('3d', false),
            new Card('5c', false),
            new Card('7h', false),

        ];

        $card1 = new Card('7c', true);
        $card2 = new Card('8c', true);
        array_push($cards, $card1, $card2);

        $calculate = new \App\Service\CardCalculate();
        $this->assertEquals($calculate->calculate($cards)->getWeight(), CardCalculate::$weight[CardCalculate::ONE_PAIR]);
        $this->assertEquals($calculate->calculate($cards)->getOutput(), '[4h 5c 7h 7c 8c]');
    }
}
