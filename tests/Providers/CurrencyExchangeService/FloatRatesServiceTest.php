<?php
/**
 * Created by PhpStorm.
 * User: tahirqureshi
 * Date: 12/09/19
 * Time: 17:51
 */

namespace Tests\Providers\CurrencyExchangeService;


use App\Providers\CurrencyExchangeService\FloatRatesService;

/**
 * Class FloatRatesServiceTest
 *
 * @covers  \App\Providers\CurrencyExchangeService\FloatRatesService
 * @package Tests\Providers\CurrencyExchangeService
 */
class FloatRatesServiceTest extends AbstractCurrencyExchangeService
{

    /**
     * @var FloatRatesService $service
     */
    protected $service;

    public function setUp(): void
    {

        $this->service = new FloatRatesService();
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
        $property->setValue(simplexml_load_string(self::getTestXml()));

        $method = $reflection->getMethod('filterData');
        $actual   = $method->invoke($this->service);

        $expected = [
            'USD' => [
                'rate' => '1.23293427',
            ],
            'EUR' => [
                'rate' => '1.11839430',
            ],
            'AUD' => [
                'rate' => '1.79190447',
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
<?xml-stylesheet type="text/xsl" href="http://www.floatrates.com/currency-rates.xsl" ?>
<channel>
	<title>XML Daily Foreign Exchange Rates for U.K. Pound Sterling (GBP)</title>
	<link>http://www.floatrates.com/currency/gbp/</link>
	<xmlLink>http://www.floatrates.com/daily/gbp.xml</xmlLink>
	<description>XML Daily foreign exchange rates for U.K. Pound Sterling (GBP) from the Float Rates. Published at Thu, 12 Sep 2019 12:00:02 GMT.</description>
	<language>en</language>
	<baseCurrency>GBP</baseCurrency>
	<pubDate>Thu, 12 Sep 2019 12:00:02 GMT</pubDate>
	<lastBuildDate>Thu, 12 Sep 2019 12:00:02 GMT</lastBuildDate>
	<item>
		<title>1 GBP = 1.23293427 USD</title>
		<link>http://www.floatrates.com/gbp/usd/</link>
		<description>1 U.K. Pound Sterling = 1.23293427 U.S. Dollar</description>
		<pubDate>Thu, 12 Sep 2019 12:00:02 GMT</pubDate>
		<baseCurrency>GBP</baseCurrency>
		<baseName>U.K. Pound Sterling</baseName>
		<targetCurrency>USD</targetCurrency>
		<targetName>U.S. Dollar</targetName>
		<exchangeRate>1.23293427</exchangeRate>
		<inverseRate>0.81107325</inverseRate>
		<inverseDescription>1 U.S. Dollar = 0.81107325 U.K. Pound Sterling</inverseDescription>
	</item>
	<item>
		<title>1 GBP = 1.11839430 EUR</title>
		<link>http://www.floatrates.com/gbp/eur/</link>
		<description>1 U.K. Pound Sterling = 1.11839430 Euro</description>
		<pubDate>Thu, 12 Sep 2019 12:00:02 GMT</pubDate>
		<baseCurrency>GBP</baseCurrency>
		<baseName>U.K. Pound Sterling</baseName>
		<targetCurrency>EUR</targetCurrency>
		<targetName>Euro</targetName>
		<exchangeRate>1.11839430</exchangeRate>
		<inverseRate>0.89413903</inverseRate>
		<inverseDescription>1 Euro = 0.89413903 U.K. Pound Sterling</inverseDescription>
	</item>
	<item>
		<title>1 GBP = 1.79190447 AUD</title>
		<link>http://www.floatrates.com/gbp/aud/</link>
		<description>1 U.K. Pound Sterling = 1.79190447 Australian Dollar</description>
		<pubDate>Thu, 12 Sep 2019 12:00:02 GMT</pubDate>
		<baseCurrency>GBP</baseCurrency>
		<baseName>U.K. Pound Sterling</baseName>
		<targetCurrency>AUD</targetCurrency>
		<targetName>Australian Dollar</targetName>
		<exchangeRate>1.79190447</exchangeRate>
		<inverseRate>0.55806546</inverseRate>
		<inverseDescription>1 Australian Dollar = 0.55806546 U.K. Pound Sterling</inverseDescription>
	</item>
</channel>
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
        self::assertTrue($method->invoke($this->service, $END_POINT . 'gbp.xml'));
    }
}
