<?php

namespace imanilchaudhari\CurrencyConverter\Tests\Provider;

use imanilchaudhari\CurrencyConverter\Provider\OpenExchangeRatesApi;
use yii\base\InvalidConfigException;

class OpenExchangeRatesApiTest extends ProviderTestCase
{
    private function makeProvider(): OpenExchangeRatesApi
    {
        return new OpenExchangeRatesApi('test-app-id');
    }

    public function testGetRateReturnsCorrectFloat(): void
    {
        $provider = $this->makeProvider();
        $this->injectMockTransport($provider, $this->makeResponse([
            'disclaimer' => 'Usage subject to terms.',
            'base'       => 'USD',
            'rates'      => ['EUR' => 0.85, 'NPR' => 132.50],
        ]));

        $this->assertSame(0.85, $provider->getRate('USD', 'EUR'));
    }

    public function testGetRateThrowsOnApiError(): void
    {
        $provider = $this->makeProvider();
        $this->injectMockTransport($provider, $this->makeResponse([
            'error'       => true,
            'status'      => 401,
            'message'     => 'invalid_app_id',
            'description' => 'Invalid App ID provided.',
        ], 401));

        $this->expectException(InvalidConfigException::class);
        $provider->getRate('USD', 'EUR');
    }

    public function testAppIdIsAssigned(): void
    {
        $provider = new OpenExchangeRatesApi('my-app-id');
        $this->assertSame('my-app-id', $provider->appId);
    }

    public function testConstructorDefaultsAppIdToNull(): void
    {
        $provider = new OpenExchangeRatesApi();
        $this->assertNull($provider->appId);
    }
}
