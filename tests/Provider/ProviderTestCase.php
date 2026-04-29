<?php

namespace imanilchaudhari\CurrencyConverter\Tests\Provider;

use PHPUnit\Framework\TestCase;
use yii\httpclient\MockTransport;
use yii\httpclient\Response;

abstract class ProviderTestCase extends TestCase
{
    protected function makeResponse(array $data, int $statusCode = 200): Response
    {
        $response = new Response();
        $response->setData($data);
        $response->setHeaders(['http-code' => $statusCode]);

        return $response;
    }

    protected function injectMockTransport(object $provider, Response ...$responses): MockTransport
    {
        $prop = (new \ReflectionClass($provider))->getProperty('_client');
        $prop->setAccessible(true);
        $client = $prop->getValue($provider);

        $transport = new MockTransport();
        $client->setTransport($transport);

        foreach ($responses as $response) {
            $transport->appendResponse($response);
        }

        return $transport;
    }
}
