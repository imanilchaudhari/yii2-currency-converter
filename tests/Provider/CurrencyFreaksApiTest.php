<?php

namespace imanilchaudhari\CurrencyConverter\Tests\Provider;

use yii\base\InvalidConfigException;
use imanilchaudhari\CurrencyConverter\Provider\CurrencyFreaksApi;

class CurrencyFreaksApiTest extends ProviderTestCase
{
    private function makeProvider(): CurrencyFreaksApi
    {
        return new CurrencyFreaksApi('test-key');
    }

    public function testGetRateReturnsCorrectFloat(): void
    {
        $provider = $this->makeProvider();
        $this->injectMockTransport($provider, $this->makeResponse([
            'base'  => 'USD',
            'rates' => ['EUR' => 0.85, 'NPR' => 132.50],
        ]));

        $this->assertSame(0.85, $provider->getRate('USD', 'EUR'));
    }

    public function testGetRateThrowsOnApiError(): void
    {
        $provider = $this->makeProvider();
        $this->injectMockTransport($provider, $this->makeResponse([
            'message' => 'Invalid API key.',
        ], 401));

        $this->expectException(InvalidConfigException::class);
        $this->expectExceptionMessage('Invalid API key.');
        $provider->getRate('USD', 'EUR');
    }

    public function testApiKeyIsAssigned(): void
    {
        $provider = new CurrencyFreaksApi('my-secret-key');
        $this->assertSame('my-secret-key', $provider->apiKey);
    }

    public function testConstructorDefaultsApiKeyToNull(): void
    {
        $provider = new CurrencyFreaksApi();
        $this->assertNull($provider->apiKey);
    }
}
