<?php


namespace App;

use App\Service\CardCalculate;

class CardPrint
{
    /**
     * @var string
     */
    private $output;

    /**
     * @var int
     */
    private $weight;

    /**
     * @var string
     */
    private $textWeight;

    /**
     * CardPrint constructor.
     * @param string $output
     * @param int $weight
     * @param string $textWeight
     */
    public function __construct(string $output, int $weight, string $textWeight)
    {
        $this->output = $output;
        $this->weight = $weight;
        $this->textWeight = $textWeight;
    }

    /**
     * @return string
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @return string
     */
    public function getTextWeight()
    {
        return $this->textWeight;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->textWeight . ' ' . $this->getOutput();
    }
}
