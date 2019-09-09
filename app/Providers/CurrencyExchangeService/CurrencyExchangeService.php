<?php

namespace App\Providers\CurrencyExchangeService;

abstract class CurrencyExchangeService implements CurrencyExchangeServiceInterface
{

    abstract public static function isSupportedCurrency(string $currency): bool;

    abstract public static function convert(string $toCurrency, string $fromCurrency, float $amount): float;

    /**
     * @param string $endPoint
     *
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function testEndPoint(string $endPoint): bool
    {
        try {

            $client   = new \GuzzleHttp\Client();
            $response = $client->request('GET', $endPoint);

            if ($response->getStatusCode() !== 200 &&
                $response->getHeaderLine('content-type') !== 'text/xml; charset=UTF-8') {
                return false;
            }

            return true;

        } catch (\Exception $exception) {
            return false;
        }
    }
}
