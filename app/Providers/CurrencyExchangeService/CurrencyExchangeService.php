<?php

namespace App\Providers\CurrencyExchangeService;

abstract class CurrencyExchangeService implements CurrencyExchangeServiceInterface
{

    protected const END_POINT = 'Define it';

    protected const CURRENCIES = [
        "AFN",
        "EUR",
        "ALL",
        "DZD",
        "USD",
        "EUR",
        "AOA",
        "XCD",
        "XCD",
        "ARS",
        "AMD",
        "AWG",
        "AUD",
        "EUR",
        "AZN",
        "BSD",
        "BHD",
        "BDT",
        "BBD",
        "BYN",
        "EUR",
        "BZD",
        "XOF",
        "BMD",
        "INR",
        "BTN",
        "BOB",
        "BOV",
        "USD",
        "BAM",
        "BWP",
        "NOK",
        "BRL",
        "USD",
        "BND",
        "BGN",
        "XOF",
        "BIF",
        "CVE",
        "KHR",
        "XAF",
        "CAD",
        "KYD",
        "XAF",
        "XAF",
        "CLP",
        "CLF",
        "CNY",
        "AUD",
        "AUD",
        "COP",
        "COU",
        "KMF",
        "CDF",
        "XAF",
        "NZD",
        "CRC",
        "XOF",
        "HRK",
        "CUP",
        "CUC",
        "ANG",
        "EUR",
        "CZK",
        "DKK",
        "DJF",
        "XCD",
        "DOP",
        "USD",
        "EGP",
        "SVC",
        "USD",
        "XAF",
        "ERN",
        "EUR",
        "ETB",
        "EUR",
        "FKP",
        "DKK",
        "FJD",
        "EUR",
        "EUR",
        "EUR",
        "XPF",
        "EUR",
        "XAF",
        "GMD",
        "GEL",
        "EUR",
        "GHS",
        "GIP",
        "EUR",
        "DKK",
        "XCD",
        "EUR",
        "USD",
        "GTQ",
        "GBP",
        "GNF",
        "XOF",
        "GYD",
        "HTG",
        "USD",
        "AUD",
        "EUR",
        "HNL",
        "HKD",
        "HUF",
        "ISK",
        "INR",
        "IDR",
        "XDR",
        "IRR",
        "IQD",
        "EUR",
        "GBP",
        "ILS",
        "EUR",
        "JMD",
        "JPY",
        "GBP",
        "JOD",
        "KZT",
        "KES",
        "AUD",
        "KPW",
        "KRW",
        "KWD",
        "KGS",
        "LAK",
        "EUR",
        "LBP",
        "LSL",
        "ZAR",
        "LRD",
        "LYD",
        "CHF",
        "EUR",
        "EUR",
        "MOP",
        "MKD",
        "MGA",
        "MWK",
        "MYR",
        "MVR",
        "XOF",
        "EUR",
        "USD",
        "EUR",
        "MRU",
        "MUR",
        "EUR",
        "XUA",
        "MXN",
        "MXV",
        "USD",
        "MDL",
        "EUR",
        "MNT",
        "EUR",
        "XCD",
        "MAD",
        "MZN",
        "MMK",
        "NAD",
        "ZAR",
        "AUD",
        "NPR",
        "EUR",
        "XPF",
        "NZD",
        "NIO",
        "XOF",
        "NGN",
        "NZD",
        "AUD",
        "USD",
        "NOK",
        "OMR",
        "PKR",
        "USD",
        "PAB",
        "USD",
        "PGK",
        "PYG",
        "PEN",
        "PHP",
        "NZD",
        "PLN",
        "EUR",
        "USD",
        "QAR",
        "EUR",
        "RON",
        "RUB",
        "RWF",
        "EUR",
        "SHP",
        "XCD",
        "XCD",
        "EUR",
        "EUR",
        "XCD",
        "WST",
        "EUR",
        "STN",
        "SAR",
        "XOF",
        "RSD",
        "SCR",
        "SLL",
        "SGD",
        "ANG",
        "XSU",
        "EUR",
        "EUR",
        "SBD",
        "SOS",
        "ZAR",
        "SSP",
        "EUR",
        "LKR",
        "SDG",
        "SRD",
        "NOK",
        "SZL",
        "SEK",
        "CHF",
        "CHE",
        "CHW",
        "SYP",
        "TWD",
        "TJS",
        "TZS",
        "THB",
        "USD",
        "XOF",
        "NZD",
        "TOP",
        "TTD",
        "TND",
        "TRY",
        "TMT",
        "USD",
        "AUD",
        "UGX",
        "UAH",
        "AED",
        "GBP",
        "USD",
        "USD",
        "USN",
        "UYU",
        "UYI",
        "UYW",
        "UZS",
        "VUV",
        "VES",
        "VND",
        "USD",
        "USD",
        "XPF",
        "MAD",
        "YER",
        "ZMW",
        "ZWL",
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
     * Can be used to see if end point is correct
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
     * makes request, gets the xml data from the end point converts it to xml
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
     * Returns the converted prices
     * -1 means it was not found
     * @param string $fromCurrency
     * @param float  $amount
     *
     * @param array  $rates
     *
     * @return float
     */
    protected static function getConvertedPrice(string $fromCurrency, float $amount, array $rates): float
    {

        if(!empty($rates) && isset($rates[$fromCurrency])) {

            return ($amount * $rates[$fromCurrency]['rate']);
        }
        return -1;
    }

    /**
     * Check if it is supported by the services
     * @param string $currency
     *
     * @return bool
     */
    public static function isSupportedCurrency(string $currency): bool
    {
        return in_array($currency, self::CURRENCIES, true);
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
        return self::CURRENCIES;
    }

}
