<?php

namespace App\Tests\Mock;

use App\Model\BitcoinPrice;
use App\Service\BitcoinPriceServiceInterface;

class MockBitcoinPriceService implements BitcoinPriceServiceInterface
{
    /**
     * @return BitcoinPrice
     */
    public function getCurrentBitcoinPrices(): BitcoinPrice
    {
        return new BitcoinPrice(30000.0, 25000.0);
    }
}
