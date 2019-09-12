<?php
/**
 * Created by PhpStorm.
 * User: tahirqureshi
 * Date: 12/09/19
 * Time: 19:08
 */

namespace Tests\Providers\CurrencyExchangeService;


use App\Providers\CurrencyExchangeService\CurrencyExchangeServiceInterface;
use Tests\TestCase;

/**
 * Class CurrencyExchangeServiceTest
 *
 * @covers  \App\Providers\CurrencyExchangeService\AbstractCurrencyExchangeService
 * @package Tests\Providers\CurrencyExchangeService
 */
class AbstractCurrencyExchangeService extends TestCase
{

    /**
     * @var CurrencyExchangeServiceInterface $service
     */
    protected $service;

    protected const CURRENCIES = [
        'GBP',
        'USD',
        'AUD',
        'EUR',
    ];

    /**
     * @test
     */
    public function isSupportedCurrency(): void
    {
        foreach (self::CURRENCIES as $CURRENCY) {
            self::assertTrue($this->service::isSupportedCurrency($CURRENCY));
        }
    }

    /**
     * @test
     */
    public function getConvertedPrice(): void
    {
        $expected = 1.79190447;
        $actual = $this->service::getConvertedPrice('AUD', 1, self::getRatesArray());
        self::assertEquals($expected, $actual);
    }

    public static function getRatesArray(): array
    {
        return [
            'USD' => [
                'rate' => 1.23293427,
            ],
            'EUR' => [
                'rate' => 1.11839430,
            ],
            'AUD' => [
                'rate' => 1.79190447,
            ],
        ];
    }
}
