<?php

namespace imanilchaudhari\CurrencyConverter\Tests\Provider;

use yii\base\InvalidConfigException;
use imanilchaudhari\CurrencyConverter\Provider\FixerApi;

class FixerApiTest extends ProviderTestCase
{
    private function makeProvider(): FixerApi
    {
        return new FixerApi('test-key');
    }

    public function testGetRateReturnsCorrectFloat(): void
    {
        $provider = $this->makeProvider();
        $this->injectMockTransport($provider, $this->makeResponse([
            'success' => true,
            'base'    => 'USD',
            'rates'   => ['EUR' => 0.85, 'GBP' => 0.73],
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

    public function testGetRateThrowsWhenSuccessFalseWithStatus200(): void
    {
        $provider = $this->makeProvider();
        $this->injectMockTransport($provider, $this->makeResponse([
            'success' => false,
            'error'   => ['code' => 105, 'info' => 'Base currency access restricted.'],
        ]));

        $this->expectException(InvalidConfigException::class);
        $this->expectExceptionMessage('Base currency access restricted.');
        $provider->getRate('EUR', 'USD');
    }

    public function testAccessKeyIsAssigned(): void
    {
        $provider = new FixerApi('my-access-key');
        $this->assertSame('my-access-key', $provider->access_key);
    }

    public function testConstructorDefaultsAccessKeyToNull(): void
    {
        $provider = new FixerApi();
        $this->assertNull($provider->access_key);
    }
}
