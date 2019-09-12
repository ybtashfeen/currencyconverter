<?php

namespace App\Helpers;

use App\Providers\CurrencyExchangeService\CurrencyExchangeServiceInterface;

/**
 * Class CurrencyExchangeHelper
 *
 * @package App\Helpers
 */
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
        //this will return the first active service it finds
        foreach (self::SERVICES as $SERVICE) {
            if($SERVICE::ACTIVE) {
                $this->activeService = $SERVICE;
                break;
            }
        }
    }


    /** goes through the service and converts the amount
     * @param string $toCurrency
     * @param string $fromCurrency
     * @param float  $amount
     *
     * @return string
     */
    public function convert(string $toCurrency, string $fromCurrency, float $amount): string
    {
        if($this->activeService !== null) {

            return number_format($this->activeService::convert($toCurrency, $fromCurrency, $amount), 2, '.', ',');
        }
        return -1;
    }

    /**
     * @return array
     */
    public function getAllCurrencies(): array
    {
        return $this->activeService::getAllCurrencies();
    }

}
