<?php

namespace App\Controller;

use App\Service\BitcoinPriceServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

class BitcoinController extends AbstractController
{
    private BitcoinPriceServiceInterface $bitcoinPriceService;

    public function __construct(BitcoinPriceServiceInterface $bitcoinPriceService)
    {
        $this->bitcoinPriceService = $bitcoinPriceService;
    }

    /**
     * @Route("/", name="bitcoin")
     *
     * @return Response
     */
    public function index(): Response
    {
        try {
            $bitcoinPrices = $this->bitcoinPriceService->getCurrentBitcoinPrices();
        } catch (ExceptionInterface $e) {
            return $this->render('error.html.twig', [
                'error' => 'Failed to fetch Bitcoin price. Please try again later.',
            ]);
        }

        return $this->render('index.html.twig', [
            'usd' => $bitcoinPrices->getUsdPrice(),
            'eur' => $bitcoinPrices->getEurPrice(),
        ]);
    }

    /**
     * @Route("/bitcoin-price", name="bitcoin_price")
     *
     * @return Response
     */
    public function getBitcoinPriceJson(): Response
    {
        try {
            $bitcoinPrices = $this->bitcoinPriceService->getCurrentBitcoinPrices();
        } catch (ExceptionInterface $e) {
            return $this->json([
                'error' => 'Failed to fetch Bitcoin price. Please try again later.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json([
            'usd' => $bitcoinPrices->getUsdPrice(),
            'eur' => $bitcoinPrices->getEurPrice(),
        ]);
    }
}
