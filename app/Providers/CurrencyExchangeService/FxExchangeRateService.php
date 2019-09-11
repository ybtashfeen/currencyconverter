<?php

namespace App\Providers\CurrencyExchangeService;

class FxExchangeRateService extends CurrencyExchangeService
{

    public const ACTIVE = false;

    protected const END_POINT = 'fxexchangerate.com/rss.xml';

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

        self::$endPoint = 'https://' . $fromCurrency . '.' . self::END_POINT;

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
            foreach (self::$ratesXml->channel->item as $item) {

                preg_match_all('/\((.*?)\)/', $item->title, $currencies);

                if (array_key_exists($currencies[1][1], self::CURRENCIES)) {

                    $desc = explode('=', $item->description)[1];

                    preg_match('/[0-9\.]+/', $desc, $rate);
                    $rates[$currencies[1][1]]['rate'] = $rate[0];
                }
            }
        }

        return $rates;
    }

}
