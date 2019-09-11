<?php

namespace App\Providers\CurrencyExchangeService;

interface CurrencyExchangeServiceInterface
{
    /**
     * Checks id Currency is supported by this service
     *
     * @param string $currency
     *
     * @return bool
     */
    public static function isSupportedCurrency(string $currency): bool;

    /**
     * @return array
     */
    public static function filterData(): array;

    /**
     * Converts the currencies
     *
     * @param string $toCurrency
     * @param string $fromCurrency
     * @param float  $amount
     *
     * @return float
     */
    public static function convert(string $toCurrency, string $fromCurrency, float $amount): float;

    /**
     * Test if the service is available
     * @param string $endPoint
     *
     * @return void
     */
    public static function testEndPoint(string $endPoint): bool;
}
