<?php

namespace App\Service;

use App\Model\BitcoinPrice;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class BitcoinPriceService.
 */
class BitcoinPriceService implements BitcoinPriceServiceInterface
{
    private HttpClientInterface $client;
    private string $apiUrl;

    /**
     * BitcoinPriceService constructor.
     *
     * @param HttpClientInterface $client The HTTP client to fetch data from the API.
     * @param string              $apiUrl The API URL to fetch Bitcoin price data.
     */
    public function __construct(HttpClientInterface $client, string $apiUrl)
    {
        $this->client = $client;
        $this->apiUrl = $apiUrl;
    }

    /**
     * {@inheritdoc}
     *
     * @throws ExceptionInterface
     */
    public function getCurrentBitcoinPrices(): BitcoinPrice
    {
        $priceData = $this->fetchBitcoinPriceData();
        $usdPrice = (float)$priceData['bpi']['USD']['rate_float'];
        $eurPrice = (float)$priceData['bpi']['EUR']['rate_float'];

        return new BitcoinPrice($usdPrice, $eurPrice);
    }

    /**
     * Fetch Bitcoin price data from the API.
     *
     * @return array The decoded JSON data containing Bitcoin prices.
     *
     * @throws ExceptionInterface When an unsupported option is passed.
     */
    private function fetchBitcoinPriceData(): array
    {
        $response = $this->client->request('GET', $this->apiUrl);
        $content = $response->getContent();
        return json_decode($content, true, 512, JSON_THROW_ON_ERROR);
    }
}
