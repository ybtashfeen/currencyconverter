<?php

namespace App\Providers\CurrencyExchangeService;

abstract class CurrencyExchangeService implements CurrencyExchangeServiceInterface
{

    protected const END_POINT = 'Define it';

    protected const GBP = 'GBP';
    protected const USD = 'USD';
    protected const EUR = 'EUR';
    protected const AUD = 'AUD';

    protected const GBP_CURRENCY = 'GBP';
    protected const GBP_TITLE    = 'U.K. Pound Sterling';

    protected const USD_CURRENCY = 'USD';
    protected const USD_TITLE    = 'U.S. Dollar';

    protected const EUR_CURRENCY = 'EUR';
    protected const EUR_TITLE    = 'U.S. Dollar';

    protected const AUD_CURRENCY = 'AUD';
    protected const AUD_TITLE    = 'Australian Dollar';

    protected const CURRENCIES = [
        self::GBP => [
            self::GBP_CURRENCY,
            self::GBP_TITLE,
        ],
        self::USD => [
            self::USD_CURRENCY,
            self::USD_TITLE,
        ],
        self::EUR => [
            self::EUR_CURRENCY,
            self::EUR_TITLE,
        ],
        self::AUD => [
            self::AUD_CURRENCY,
            self::AUD_TITLE,
        ],
    ];

    /**
     * @var \SimpleXMLElement $ratesXml
     */
    protected static $ratesXml = '';

    /**
     * @var string $endPoint
     */
    protected static $endPoint;
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

    /**
     * @param string $endPoint
     *
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected static function makeRequest(string $endPoint): bool
    {
        $client      = new \GuzzleHttp\Client();
        $response    = $client->request('GET', $endPoint)->getBody()->getContents();
        $responseXml = \simplexml_load_string($response);

        if ($responseXml instanceof \SimpleXMLElement) {
            self::$ratesXml = $responseXml;

            return true;
        }

        return false;
    }

    /**
     * @param string $fromCurrency
     * @param float  $amount
     *
     * @param array  $rates
     *
     * @return float
     */
    protected static function getConvertedPrice(string $fromCurrency, float $amount, array $rates): float
    {

        if(!empty($rates)) {

            return ($amount * $rates[$fromCurrency]['rate']);
        }
        return -1;
    }

    /**
     * @param string $currency
     *
     * @return bool
     */
    public static function isSupportedCurrency(string $currency): bool
    {
        return isset(self::CURRENCIES[$currency]);
    }

    /**
     * @param string $toCurrency
     * @param string $fromCurrency
     * @param float  $amount
     *
     * @return float
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function convert(string $toCurrency, string $fromCurrency, float $amount): float
    {
        if (!self::isSupportedCurrency($toCurrency)) {
            throw new \RuntimeException('To Currency Not Supported');
        }
        if (!self::isSupportedCurrency($fromCurrency)) {
            throw new \RuntimeException('From Currency Not Supported');
        }
        //self::testEndPoint(self::$endPoint);

        if (self::makeRequest(self::$endPoint)) {
            return self::getConvertedPrice($toCurrency, $amount, static::filterData());
        }

        return -1;

    }

    public static function getAllCurrencies(): array
    {
        return array_keys(self::CURRENCIES);
    }

}
