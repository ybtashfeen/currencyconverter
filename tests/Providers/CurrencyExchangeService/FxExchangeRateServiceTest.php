<?php
/**
 * Created by PhpStorm.
 * User: tahirqureshi
 * Date: 12/09/19
 * Time: 17:51
 */

namespace Tests\Providers\CurrencyExchangeService;


use App\Providers\CurrencyExchangeService\FxExchangeRateService;

/**
 * Class FxExchangeRateServiceTest
 *
 * @covers  \App\Providers\CurrencyExchangeService\FxExchangeRateService
 * @package Tests\Providers\CurrencyExchangeService
 */
class FxExchangeRateServiceTest extends AbstractCurrencyExchangeService
{

    /**
     * @var FxExchangeRateService $service
     */
    protected $service;

    public function setUp(): void
    {

        $this->service = new FxExchangeRateService();
    }

    /**
     * @test
     * @throws \ReflectionException
     */
    public function filterData(): void
    {
        $reflection = new \ReflectionObject($this->service);
        $property   = $reflection->getProperty('ratesXml');
        $property->setAccessible(true);
        $property->setValue(\simplexml_load_string(self::getTestXml()));

        $method = $reflection->getMethod('filterData');
        $actual   = $method->invoke($this->service);

        $expected = [
            'USD' => [
                'rate' => '1.23478',
            ],
            'EUR' => [
                'rate' => '1.11488',
            ],
            'AUD' => [
                'rate' => '1.79654',
            ],

        ];
        self::assertSame($expected, $actual);
    }

    /**
     * @return string
     */
    public static function getTestXml(): string
    {
        return <<<RATES_XML
<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>British Pound(GBP) Currency Converter</title>
        <link>https://gbp.fxexchangerate.com/</link>
        <description>British Pound(GBP) Exchange Rates</description>
        <lastBuildDate>Thu Sep 12 2019 18:24:03 UTC </lastBuildDate>
        <language>en</language>
        <copyright>Copyright© 2019 Currency Converter,  https://www.fxexchangerate.com/ </copyright>
        <docs>https://www.fxexchangerate.com/currency-converter-rss-feed.html</docs>
        <ttl>15</ttl>
       <item>
            <title>British Pound(GBP)/United States Dollar(USD)</title>
            <link>https://usd.fxexchangerate.com/</link>
            <guid>https://usd.fxexchangerate.com/</guid>
            <pubDate>Thu Sep 12 2019 18:24:03 UTC </pubDate>
            <description>1 British Pound = 1.23478 United States Dollar</description>
            <category>British Pound</category>
        </item>
        <item>
            <title>British Pound(GBP)/Euro(EUR)</title>
            <link>https://eur.fxexchangerate.com/</link>
            <guid>https://eur.fxexchangerate.com/</guid>
            <pubDate>Thu Sep 12 2019 18:24:03 UTC </pubDate>
            <description>1 British Pound = 1.11488 Euro</description>
            <category>British Pound</category>
        </item>
        <item>
            <title>British Pound(GBP)/Australian Dollar(AUD)</title>
            <link>https://aud.fxexchangerate.com/</link>
            <guid>https://aud.fxexchangerate.com/</guid>
            <pubDate>Thu Sep 12 2019 18:24:03 UTC </pubDate>
            <description>1 British Pound = 1.79654 Australian Dollar</description>
            <category>British Pound</category>
        </item>
    </channel>
</rss>
RATES_XML;

    }

    /**
     * @test
     * @throws \ReflectionException
     */
    public function makeRequest(): void
    {
        $reflection = new \ReflectionObject($this->service);
        $END_POINT  = $reflection->getConstant('END_POINT');
        $method     = $reflection->getMethod('makeRequest');

        $method->setAccessible(true);
        self::assertTrue($method->invoke($this->service, 'http//gbp'. $END_POINT ));
    }
}
