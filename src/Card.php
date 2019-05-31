<?php


namespace App;

use App\Exception\NotCorrectCardException;


class Card
{

    const VALUES = [
        '2' => 2,
        '3' => 3,
        '4' => 4,
        '5' => 5,
        '6' => 6,
        '7' => 7,
        '8' => 8,
        '9' => 9,
        '10' => 10,
        'J' => 11,
        'Q' => 12,
        'K' => 13,
        'A' => 14
    ];

    const COLORS = [
        'c' => 'c',
        'd' => 'd',
        'h' => 'h',
        's' => 's'
    ];

    private $value;

    private $color;

    private $isPlayerCard;

    /**
     * Card constructor.
     *
     * @param $text
     *
     * @throws NotCorrectCardException
     */
    public function __construct(string $text, $isPlayerCard)
    {
        $value = substr_replace($text, '', -1, 1);
        $color = mb_substr($text, -1, 1);
        $this->isPlayerCard = $isPlayerCard;

        if($this->isCorrectCard($value, $color)) {
            $this->value = $value;
            $this->color = $color;
        } else {
            throw new NotCorrectCardException();
        }
    }

    /**
     * @return mixed
     */
    public function getIsPlayerCard()
    {
        return $this->isPlayerCard;
    }

    /**
     * @return bool|string
     */
    public function getValue()
    {
        return $this->value;
    }

    public function getIntValue()
    {
        return self::VALUES[$this->value];
    }

    /**
     * @return bool|string
     */
    public function getColor()
    {
        return $this->color;
    }

    private function isCorrectCard(string $value, string $color): bool
    {
        return isset(self::VALUES[$value]) && isset(self::COLORS[$color]);
    }


}