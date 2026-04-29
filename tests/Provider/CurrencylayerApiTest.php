<?php

namespace imanilchaudhari\CurrencyConverter\Tests\Provider;

use yii\base\InvalidConfigException;
use imanilchaudhari\CurrencyConverter\Provider\CurrencylayerApi;

class CurrencylayerApiTest extends ProviderTestCase
{
    private function makeProvider(): CurrencylayerApi
    {
        return new CurrencylayerApi('test-key');
    }

    public function testGetRateReturnsCorrectFloat(): void
    {
        $provider = $this->makeProvider();
        $this->injectMockTransport($provider, $this->makeResponse([
            'success' => true,
            'source'  => 'USD',
            'quotes'  => ['USDEUR' => 0.85, 'USDNPR' => 132.50],
        ]));

        $this->assertSame(0.85, $provider->getRate('USD', 'EUR'));
    }

    public function testGetRateThrowsOnApiError(): void
    {
        $provider = $this->makeProvider();
        $this->injectMockTransport($provider, $this->makeResponse([
            'success' => false,
            'error'   => ['code' => 101, 'info' => 'Invalid access key.'],
        ], 401));

        $this->expectException(InvalidConfigException::class);
        $this->expectExceptionMessage('Invalid access key.');
        $provider->getRate('USD', 'EUR');
    }

    public function testQuoteKeyUsesConcatenatedSourceAndTarget(): void
    {
        $provider = $this->makeProvider();
        $this->injectMockTransport($provider, $this->makeResponse([
            'success' => true,
            'source'  => 'GBP',
            'quotes'  => ['GBPJPY' => 192.30],
        ]));

        $this->assertSame(192.30, $provider->getRate('GBP', 'JPY'));
    }

    public function testAccessKeyIsAssigned(): void
    {
        $provider = new CurrencylayerApi('my-access-key');
        $this->assertSame('my-access-key', $provider->access_key);
    }

    public function testConstructorDefaultsAccessKeyToNull(): void
    {
        $provider = new CurrencylayerApi();
        $this->assertNull($provider->access_key);
    }
}
