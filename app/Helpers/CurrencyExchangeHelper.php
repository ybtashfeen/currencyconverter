<?php

namespace App\Helpers;

use App\Providers\CurrencyExchangeService\CurrencyExchangeServiceInterface;

class CurrencyExchangeHelper
{

    protected const FloatRatesService = 'App\Providers\CurrencyExchangeService\FloatRatesService';

    protected const SERVICES = [
        self::FloatRatesService
    ];

    /**
     * @var CurrencyExchangeServiceInterface $activeService
     */
    protected $activeService;


    public function __construct()
    {
        //get active service
        foreach (self::SERVICES as $SERVICE) {
            if($SERVICE::ACTIVE) {
                $this->activeService = $SERVICE;
                break;
            }
        }
    }


    /**
     * @param string $toCurrency
     * @param string $fromCurrency
     * @param float  $amount
     *
     * @return float
     */
    public function convert(string $toCurrency, string $fromCurrency, float $amount): float
    {
        return $this->activeService::convert($toCurrency, $fromCurrency, $amount);
    }

}
