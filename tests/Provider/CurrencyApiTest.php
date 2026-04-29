<?php

namespace imanilchaudhari\CurrencyConverter\Tests\Provider;

use imanilchaudhari\CurrencyConverter\Provider\CurrencyApi;
use yii\base\InvalidConfigException;

class CurrencyApiTest extends ProviderTestCase
{
    private function makeProvider(): CurrencyApi
    {
        return new CurrencyApi('test-key');
    }

    public function testGetRateReturnsCorrectFloat(): void
    {
        $provider = $this->makeProvider();
        $this->injectMockTransport($provider, $this->makeResponse([
            'data' => [
                'EUR' => ['code' => 'EUR', 'value' => 0.85],
            ],
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

    public function testGetRateThrowsWhenTargetMissingFromResponse(): void
    {
        $provider = $this->makeProvider();
        $this->injectMockTransport($provider, $this->makeResponse([
            'data' => ['EUR' => ['code' => 'EUR', 'value' => 0.85]],
        ]));

        $this->expectException(InvalidConfigException::class);
        $provider->getRate('USD', 'XYZ');
    }

    public function testApiKeyIsAssigned(): void
    {
        $provider = new CurrencyApi('my-secret-key');
        $this->assertSame('my-secret-key', $provider->apiKey);
    }

    public function testConstructorDefaultsApiKeyToNull(): void
    {
        $provider = new CurrencyApi();
        $this->assertNull($provider->apiKey);
    }
}
