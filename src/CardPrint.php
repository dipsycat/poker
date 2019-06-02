<?php


namespace App;

use App\Service\CardCalculate;

class CardPrint
{
    private $output;
    private $weight;

    public function __construct($output, $weight, $textWeight)
    {
        $this->output = $output;
        $this->weight = $weight;
        $this->textWeight = $textWeight;
    }

    /**
     * @return mixed
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @return mixed
     */
    public function getTextWeight()
    {
        return $this->textWeight;
    }

    public function __toString()
    {
        return $this->textWeight . ' ' . $this->getOutput();
    }
}
