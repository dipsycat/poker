<?php


namespace App;


class Player
{
    private $card1;
    private $card2;
    private $name;

    public function __construct(string $name, Card $card1, Card $card2)
    {
        $this->card1 = $card1;
        $this->card2 = $card2;
        $this->name = $name;
    }

    /**
     * @return Card
     */
    public function getCard1(): Card
    {
        return $this->card1;
    }

    /**
     * @return Card
     */
    public function getCard2(): Card
    {
        return $this->card2;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }



}
