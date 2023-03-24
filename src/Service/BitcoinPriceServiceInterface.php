<?php

namespace App\Service;

use App\Model\BitcoinPrice;

/**
 * Interface BitcoinPriceServiceInterface.
 */
interface BitcoinPriceServiceInterface
{
    /**
     * Get the current Bitcoin price.
     *
     * @return BitcoinPrice The current Bitcoin price.
     */
    public function getCurrentBitcoinPrices(): BitcoinPrice;
}
