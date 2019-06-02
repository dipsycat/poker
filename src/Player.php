<?php


namespace App;

class Player
{
    /**
     * @var Card
     */
    private $card1;

    /**
     * @var Card
     */
    private $card2;

    /**
     * @var string
     */
    private $name;

    /**
     * Player constructor.
     * @param string $name
     * @param Card $card1
     * @param Card $card2
     */
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
