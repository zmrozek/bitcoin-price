<?php

namespace App\Model;

class BitcoinPrice
{
    private float $usdPrice;
    private float $eurPrice;

    public function __construct(float $usdPrice, float $eurPrice)
    {
        $this->usdPrice = $usdPrice;
        $this->eurPrice = $eurPrice;
    }

    public function getUsdPrice(): float
    {
        return $this->usdPrice;
    }

    public function getEurPrice(): float
    {
        return $this->eurPrice;
    }
}
