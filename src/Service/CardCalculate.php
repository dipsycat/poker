<?php

namespace App\Service;

use App\Card;
use App\CardPrint;

class CardCalculate
{
    const ROYAL_FLUSH = 'Royal Flush';
    const STRAIGHT_FLUSH = 'Straight Flush';
    const FOUR_OF_A_KIND = 'Four of a Kind';
    const FULL_HOUSE = 'Full House';
    const FLUSH = 'Flush';
    const STRAIGHT = 'Straight';
    const THREE_OF_A_KIND = 'Three of a Kind';
    const TWO_PAIR = 'Two pair';
    const ONE_PAIR = 'One pair';
    const HIGH_CARD = 'High card';

    public static $weight = [
        self::HIGH_CARD => 1,
        self::ONE_PAIR => 2,
        self::TWO_PAIR => 3,
        self::THREE_OF_A_KIND => 4,
        self::STRAIGHT => 5,
        self::FLUSH => 6,
        self::FULL_HOUSE => 7,
        self::FOUR_OF_A_KIND => 8,
        self::STRAIGHT_FLUSH => 9,
        self::ROYAL_FLUSH => 10
    ];

    public function calculate($cards)
    {
        $pairs = [];
        $flush = [];
        $colorObj = [];
        $pairsObj = [];

        /** @var Card $card */
        foreach ($cards as $card) {
            if (!isset($flush[$card->getColor()])) {
                $flush[$card->getColor()] = 1;
            } else {
                $flush[$card->getColor()]++;
            }

            $colorObj[$card->getColor()][$card->getIntValue()] = $card;


            $pairsObj[$card->getIntValue()][] = $card;
            if (!isset($pairs[$card->getIntValue()])) {
                $pairs[$card->getIntValue()] = 1;
            } else {
                $pairs[$card->getIntValue()]++;
            }
        }

        if ($objs = $this->isRoyalFlush($colorObj)) {
            return new CardPrint($this->printCards($objs), $this->getWeightByName(self::ROYAL_FLUSH), self::ROYAL_FLUSH);
        } elseif ($objs = $this->isStraightFlush($colorObj)) {
            return new CardPrint($this->printCards($objs), $this->getWeightByName(self::STRAIGHT_FLUSH), self::STRAIGHT_FLUSH);
        } elseif ($objs = $this->isFour($pairsObj)) {
            return new CardPrint($this->printCards($objs), $this->getWeightByName(self::FOUR_OF_A_KIND), self::FOUR_OF_A_KIND);
        } elseif ($objs = $this->isFullHouse($pairsObj)) {
            return new CardPrint($this->printCards($objs), $this->getWeightByName(self::FULL_HOUSE), self::FULL_HOUSE);
        } elseif ($objs = $this->isFlush($colorObj)) {
            return new CardPrint($this->printCards($objs), $this->getWeightByName(self::FLUSH), self::FLUSH);
        } elseif ($objs = $this->isStraight($pairsObj)) {
            return new CardPrint($this->printCards($objs), $this->getWeightByName(self::STRAIGHT), self::STRAIGHT);
        } elseif ($objs = $this->isThird($pairsObj)) {
            return new CardPrint($this->printCards($objs), $this->getWeightByName(self::THREE_OF_A_KIND), self::THREE_OF_A_KIND);
        } elseif ($objs = $this->isTwoPair($pairsObj)) {
            return new CardPrint($this->printCards($objs), $this->getWeightByName(self::TWO_PAIR), self::TWO_PAIR);
        } elseif ($objs = $this->isPair($pairsObj)) {
            return new CardPrint($this->printCards($objs), $this->getWeightByName(self::ONE_PAIR), self::ONE_PAIR);
        } elseif ($objs = $this->isHighCard($pairsObj)) {
            return new CardPrint($this->printCards($objs), $this->getWeightByName(self::HIGH_CARD), self::HIGH_CARD);
        }
    }

    public function getWeightByName($name)
    {
        return static::$weight[$name];
    }

    public function printCards($objs)
    {
        $arr = [];
        $userCards = [];
        for ($i = 2; $i <= 14; $i++) {
            if (!isset($objs[$i])) {
                continue;
            }

            /** @var Card $obj */
            foreach ($objs[$i] as $obj) {
                //$arr[] = $obj->getValue() . $obj->getColor();
                $arr[] = $obj;
                if ($obj->isPlayerCard()) {
                    $userCards[] = $obj;
                }
            }
        }
        usort($arr, ['App\Service\CardCalculate', 'sortCardsAsc']);
        $arrText = [];
        /** @var Card $ob */
        foreach ($arr as $ob) {
            $arrText[] = $ob->getValue() . $ob->getColor();
        }
        if ($userCards) {
            usort($userCards, ['App\Service\CardCalculate', 'sortCardsDesc']);
            $userCardsText = [];
            /** @var Card $userCard */
            foreach ($userCards as $userCard) {
                $userCardsText[] = $userCard->getValue() . $userCard->getColor();
            }

            return '[' . implode(' ', $arrText) . '] [' . implode(' ', $userCardsText) . ']';
        } else {
            return '[' . implode(' ', $arrText) . ']';
        }
    }

    public function isRoyalFlush($colorObj)
    {
        $isSequence = false;
        $count = 0;
        $highCards = [];
        foreach ($colorObj as $color) {
            if (count($color) >= 5) {
                for ($i = 14; $i >= 10; $i--) {
                    if (isset($color[$i])) {
                        $isSequence = true;
                        $count++;
                        $highCards[$i] = [$color[$i]];
                        if ($count == 5) {
                            break;
                        }
                    } elseif ($isSequence) {
                        $isSequence = false;
                        $count = 0;
                        $highCards = [];
                    }
                }
            }
        }
        return ($isSequence && $count == 5) ? $highCards : 0;
    }

    public function isStraightFlush($colorObj)
    {
        $isSequence = false;
        $count = 0;
        $highCards = [];
        foreach ($colorObj as $color) {
            if (count($color) >= 5) {
                for ($i = 14; $i >= 2; $i--) {
                    if (isset($color[$i])) {
                        $isSequence = true;
                        $count++;
                        $highCards[$i] = [$color[$i]];
                        if ($count == 5) {
                            break;
                        }
                    } elseif ($isSequence) {
                        $isSequence = false;
                        $count = 0;
                        $highCards = [];
                    }
                }
            }
        }
        return ($isSequence && $count == 5) ? $highCards : 0;
    }

    public function isFullHouse($pairsObj)
    {
        $highCards = [];
        $count = 0;
        for ($i = 14; $i >= 2; $i--) {
            if (isset($pairsObj[$i])) {
                if (count($pairsObj[$i]) == 3) {
                    $highCards[$i] = $pairsObj[$i];
                    unset($pairsObj[$i]);
                    $count += 3;
                } elseif (count($pairsObj[$i]) == 2) {
                    $highCards[$i] = $pairsObj[$i];
                    unset($pairsObj[$i]);
                    $count += 2;
                }
            }
            if ($count == 5) {
                break;
            }
        }
        if ($count != 5) {
            return 0;
        }
        return $highCards;
    }

    public function isFlush($colorObjs)
    {
        $res = [];
        foreach ($colorObjs as $colorObj) {
            if (count($colorObj) >= 5) {
                for ($i = 14; $i >= 2; $i--) {
                    if (!isset($colorObj[$i])) {
                        continue;
                    }
                    $res[$i] = [$colorObj[$i]];
                    if (count($res) == 5) {
                        break;
                    }
                }
                break;
            }
        }
        return $res;
    }

    public function isStraight($pairsObj)
    {
        $isSequence = false;
        $count = 0;
        $highCards = [];
        for ($i = 14; $i >= 2; $i--) {
            if (isset($pairsObj[$i])) {
                $isSequence = true;
                $count++;
                $highCards[$i] = [$pairsObj[$i][0]];
                if ($count == 5) {
                    break;
                }
            } elseif ($isSequence) {
                $isSequence = false;
                $count = 0;
                $highCards = [];
            }
        }
        return ($isSequence && $count == 5) ? $highCards : 0;
    }

    public function isFour($pairsObj)
    {
        $highCards = [];
        $count = 0;
        $isFour = false;
        for ($i = 14; $i >= 2; $i--) {
            if (isset($pairsObj[$i])) {
                if (count($pairsObj[$i]) == 4) {
                    $highCards[$i] = $pairsObj[$i];
                    unset($pairsObj[$i]);
                    $count += 4;
                    $isFour = true;
                    break;
                }
            }
            if ($count == 5) {
                break;
            }
        }
        if (!$isFour) {
            return 0;
        }

        for ($i = 14; $i >= 2; $i--) {
            if (isset($pairsObj[$i])) {
                $highCards[$i] = $pairsObj[$i];
                $count++;
            }
            if ($count == 5) {
                break;
            }
        }
        return $highCards;
    }

    public function isThird($pairsObj)
    {
        $highCards = [];
        $count = 0;
        $isThird = false;

        for ($i = 14; $i >= 2; $i--) {
            if (isset($pairsObj[$i])) {
                if (count($pairsObj[$i]) == 3) {
                    $highCards[$i] = $pairsObj[$i];
                    unset($pairsObj[$i]);
                    $count += 3;
                    $isThird = true;
                    break;
                }
            }
            if ($count == 5) {
                break;
            }
        }
        if (!$isThird) {
            return 0;
        }
        for ($i = 14; $i >= 2; $i--) {
            if (isset($pairsObj[$i])) {
                $highCards[$i] = $pairsObj[$i];
                $count++;
            }
            if ($count == 5) {
                break;
            }
        }
        return $highCards;
    }

    public function isPair($pairsObj)
    {
        $highCards = [];
        $count = 0;
        $isPair = false;
        for ($i = 14; $i >= 2; $i--) {
            if (isset($pairsObj[$i])) {
                if (count($pairsObj[$i]) == 2) {
                    $highCards[$i] = $pairsObj[$i];
                    unset($pairsObj[$i]);
                    $count += 2;
                    $isPair = true;
                    break;
                }
            }
            if ($count == 5) {
                break;
            }
        }
        if (!$isPair) {
            return 0;
        }
        for ($i = 14; $i >= 2; $i--) {
            if (isset($pairsObj[$i])) {
                $highCards[$i] = $pairsObj[$i];
                $count++;
            }
            if ($count == 5) {
                break;
            }
        }


        return $highCards;
    }

    public function isHighCard($pairsObj)
    {
        $highCards = [];
        for ($i = 14; $i >= 2; $i--) {
            if (isset($pairsObj[$i])) {
                $highCards[$i] = $pairsObj[$i];
            }
            if (count($highCards) == 5) {
                break;
            }
        }

        return $highCards;
    }

    public function isTwoPair($pairsObj)
    {
        $highCards = [];
        $count = 0;
        $isTwoPair = false;
        for ($i = 14; $i >= 2; $i--) {
            if (isset($pairsObj[$i])) {
                if (count($pairsObj[$i]) == 2) {
                    $highCards[$i] = $pairsObj[$i];
                    unset($pairsObj[$i]);
                    $count += 2;
                    if ($count == 4) {
                        $isTwoPair = true;
                        break;
                    }
                }
            }
        }
        if (!$isTwoPair) {
            return 0;
        }

        for ($i = 14; $i >= 2; $i--) {
            if (isset($pairsObj[$i])) {
                $highCards[$i] = $pairsObj[$i];
                $count++;
            }
            if ($count == 5) {
                break;
            }
        }
        return $highCards;
    }

    public static function sortCardsDesc(Card $a, Card $b)
    {
        if ($a->getIntValue() == $b->getIntValue()) {
            if ($a->getColor() == $b->getColor()) {
                return 0;
            }
            return ($a->getColor() < $b->getColor()) ? -1 : 1;
        }
        return ($a->getIntValue() < $b->getIntValue()) ? 1 : -1;
    }

    public static function sortCardsAsc(Card $a, Card $b)
    {
        if ($a->getIntValue() == $b->getIntValue()) {
            if ($a->getColor() == $b->getColor()) {
                return 0;
            }
            return ($a->getColor() < $b->getColor()) ? -1 : 1;
        }
        return ($a->getIntValue() < $b->getIntValue()) ? -1 : 1;
    }
}
