<?php

namespace imanilchaudhari\CurrencyConverter\Tests\Provider;

use imanilchaudhari\CurrencyConverter\Provider\UniRateApi;
use yii\base\InvalidConfigException;

class UniRateApiTest extends ProviderTestCase
{
    private function makeProvider(): UniRateApi
    {
        return new UniRateApi('test-key');
    }

    public function testGetRateReturnsCorrectFloat(): void
    {
        $provider = $this->makeProvider();
        $this->injectMockTransport($provider, $this->makeResponse([
            'result' => 0.85,
        ]));

        $this->assertSame(0.85, $provider->getRate('USD', 'EUR'));
    }

    public function testGetRateThrowsOnApiError(): void
    {
        $provider = $this->makeProvider();
        $this->injectMockTransport($provider, $this->makeResponse([
            'error' => 'Invalid API key.',
        ], 401));

        $this->expectException(InvalidConfigException::class);
        $this->expectExceptionMessage('Invalid API key.');
        $provider->getRate('USD', 'EUR');
    }

    public function testApiKeyIsAssigned(): void
    {
        $provider = new UniRateApi('my-secret-key');
        $this->assertSame('my-secret-key', $provider->apiKey);
    }

    public function testConstructorDefaultsApiKeyToNull(): void
    {
        $provider = new UniRateApi();
        $this->assertNull($provider->apiKey);
    }
}
