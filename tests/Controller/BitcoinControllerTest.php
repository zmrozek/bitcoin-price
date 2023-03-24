<?php

namespace App\Tests\Controller;

use App\Service\BitcoinPriceServiceInterface;
use App\Tests\Mock\MockBitcoinPriceService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BitcoinControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $this->replaceBitcoinPriceService($container);

        $client->request('GET', '/');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Bitcoin Price');
        self::assertSelectorTextContains('#usd', '30000');
        self::assertSelectorTextContains('#eur', '25000');
    }

    public function testGetBitcoinPriceJson(): void
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $this->replaceBitcoinPriceService($container);

        $client->request('GET', '/bitcoin-price');

        self::assertResponseIsSuccessful();
        self::assertJsonStringEqualsJsonString(
            $client->getResponse()->getContent(),
            '{"usd":30000,"eur":25000}'
        );
    }

    private function replaceBitcoinPriceService(ContainerInterface $container): void
    {
        $container->set(BitcoinPriceServiceInterface::class, new MockBitcoinPriceService());
    }
}
