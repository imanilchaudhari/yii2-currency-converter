<?php

namespace imanilchaudhari\CurrencyConverter\Tests\Provider;

use yii\base\InvalidConfigException;
use imanilchaudhari\CurrencyConverter\Provider\ApiForexApi;

class ApiForexApiTest extends ProviderTestCase
{
    private function makeProvider(): ApiForexApi
    {
        return new ApiForexApi('test-key');
    }

    public function testGetRateReturnsCorrectFloat(): void
    {
        $provider = $this->makeProvider();
        $this->injectMockTransport($provider, $this->makeResponse([
            'success' => true,
            'rates'   => ['EUR' => 0.85, 'NPR' => 132.50],
        ]));

        $this->assertSame(0.85, $provider->getRate('USD', 'EUR'));
    }

    public function testGetRateThrowsOnApiError(): void
    {
        $provider = $this->makeProvider();
        $this->injectMockTransport($provider, $this->makeResponse([
            'success' => false,
            'error'   => ['message' => 'Invalid API key.'],
        ], 401));

        $this->expectException(InvalidConfigException::class);
        $provider->getRate('USD', 'EUR');
    }

    public function testGetRateThrowsOnUnsupportedCurrency(): void
    {
        $provider = $this->makeProvider();
        $this->injectMockTransport($provider, $this->makeResponse([
            'success' => true,
            'rates'   => ['EUR' => 0.85],
        ]));

        $this->expectException(InvalidConfigException::class);
        $provider->getRate('USD', 'XYZ');
    }

    public function testApiKeyIsAssigned(): void
    {
        $provider = new ApiForexApi('my-secret-key');
        $this->assertSame('my-secret-key', $provider->apiKey);
    }

    public function testConstructorDefaultsApiKeyToNull(): void
    {
        $provider = new ApiForexApi();
        $this->assertNull($provider->apiKey);
    }
}
