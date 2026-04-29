<?php

namespace imanilchaudhari\CurrencyConverter\Tests\Provider;

use imanilchaudhari\CurrencyConverter\Provider\ExchangeRatesApi;
use yii\base\InvalidConfigException;

class ExchangeRatesApiTest extends ProviderTestCase
{
    private function makeProvider(): ExchangeRatesApi
    {
        return new ExchangeRatesApi();
    }

    public function testGetRateReturnsCorrectFloat(): void
    {
        $provider = $this->makeProvider();
        $this->injectMockTransport($provider, $this->makeResponse([
            'result'    => 'success',
            'base_code' => 'USD',
            'rates'     => ['EUR' => 0.85, 'NPR' => 132.50],
        ]));

        $this->assertSame(0.85, $provider->getRate('USD', 'EUR'));
    }

    public function testGetRateThrowsOnApiError(): void
    {
        $provider = $this->makeProvider();
        $this->injectMockTransport($provider, $this->makeResponse([
            'result'     => 'error',
            'error-type' => 'unsupported-code',
            'message'    => 'Unsupported currency code.',
        ], 404));

        $this->expectException(InvalidConfigException::class);
        $provider->getRate('USD', 'XYZ');
    }

    public function testGetRateThrowsWhenResultIsNotSuccess(): void
    {
        $provider = $this->makeProvider();
        $this->injectMockTransport($provider, $this->makeResponse([
            'result'  => 'error',
            'message' => 'Invalid base code.',
        ]));

        $this->expectException(InvalidConfigException::class);
        $provider->getRate('INVALID', 'EUR');
    }

    public function testRequiresNoApiKey(): void
    {
        $this->assertInstanceOf(ExchangeRatesApi::class, new ExchangeRatesApi());
    }
}
