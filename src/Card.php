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

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $color;

    /**
     * @var bool
     */
    private $isPlayerCard;

    /**
     * Card constructor.
     *
     * @param string $text
     * @param bool   $isPlayerCard
     *
     * @throws NotCorrectCardException
     */
    public function __construct(string $text, bool $isPlayerCard)
    {
        $value = substr_replace($text, '', -1, 1);
        $color = mb_substr($text, -1, 1);
        $this->isPlayerCard = $isPlayerCard;

        if ($this->isCorrectCard($value, $color)) {
            $this->value = $value;
            $this->color = $color;
        } else {
            throw new NotCorrectCardException();
        }
    }

    /**
     * @return bool
     */
    public function isPlayerCard(): bool
    {
        return $this->isPlayerCard;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getIntValue(): int
    {
        return self::VALUES[$this->value];
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $value
     * @param string $color
     *
     * @return bool
     */
    private function isCorrectCard(string $value, string $color): bool
    {
        return isset(self::VALUES[$value]) && isset(self::COLORS[$color]);
    }
}
