<?php

namespace App\Helpers;

use App\Providers\CurrencyExchangeService\CurrencyExchangeServiceInterface;

class CurrencyExchangeHelper
{

    protected const FloatRatesService = 'App\Providers\CurrencyExchangeService\FloatRatesService';
    protected const FxExchangeRateService = 'App\Providers\CurrencyExchangeService\FxExchangeRateService';

    protected const SERVICES = [
        self::FloatRatesService,
        self::FxExchangeRateService
    ];

    /**
     * @var CurrencyExchangeServiceInterface $activeService
     */
    protected $activeService = null;


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
        if($this->activeService !== null) {

            return $this->activeService::convert($toCurrency, $fromCurrency, $amount);
        }
        return -1;
    }

}
