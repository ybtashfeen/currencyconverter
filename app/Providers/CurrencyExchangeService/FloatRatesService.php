<?php

namespace App\Providers\CurrencyExchangeService;

class FloatRatesService extends CurrencyExchangeService
{

    protected const END_POINT = 'http://www.floatrates.com/daily/';

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
    private static $ratesXml = '';

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

        $endPoint = self::END_POINT . $fromCurrency . '.xml';
        //self::testEndPoint($endPoint);

        if (self::makeRequest($endPoint)) {
            return self::getConvertedPrice($toCurrency, $amount, self::filterData());
        }

        return 0;

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
     * Filter through the xml data and return only the needed Currency Rates
     *
     * @return array
     */
    protected static function filterData(): array
    {
        $rates = [];

        if (self::$ratesXml !== null) {
            foreach (self::$ratesXml->item as $item) {
                if (array_key_exists((string)$item->targetCurrency, self::CURRENCIES)) {
                    $rates[(string)$item->targetCurrency]['rate'] = (string)$item->exchangeRate;
                }
            }
        }

        return $rates;
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

        return ($amount * $rates[$fromCurrency]['rate']);
    }

}
