<?php

namespace App\Providers\CurrencyExchangeService;

class FloatRatesService extends CurrencyExchangeService
{

    //set it to true to use this service or false to stop this service
    public const ACTIVE = true;

    protected const END_POINT = 'http://www.floatrates.com/daily/';

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

        self::$endPoint = self::END_POINT . $fromCurrency . '.xml';

        return parent::convert($toCurrency, $fromCurrency, $amount);
    }

    /**
     * Filter through the xml data and return only the needed Currency Rates
     *
     * @return array
     */
    public static function filterData(): array
    {
        $rates = [];

        if (self::$ratesXml !== null) {
            foreach (self::$ratesXml->item as $item) {
                if (in_array((string)$item->targetCurrency, self::CURRENCIES, true)) {
                    $rates[(string)$item->targetCurrency]['rate'] = (string)$item->exchangeRate;
                }
            }
        }

        return $rates;
    }

}
