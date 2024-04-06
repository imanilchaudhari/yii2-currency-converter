<?php

/**
 * @link https://github.com/imanilchaudhari
 * @copyright Copyright (c) 2024
 * @license [MIT License](https://opensource.org/license/mit)
 */

namespace imanilchaudhari\CurrencyConverter\Provider;

use yii\httpclient\Client;
use yii\base\InvalidConfigException;
use imanilchaudhari\CurrencyConverter\Interface\RateProviderInterface;

/**
 * The perfect tool to handle your exchange rate conversions.
 * Our API helps you with current and historical foreign exchanges rates.
 * Stop worrying about uptime & outdated data.
 *
 * To use CurrencyApi, configure your app component as below
 *
 * ```php
 *
 *  'components' => [
 *      'currencyConverter' => [
 *          'class' => 'imanilchaudhari\CurrencyConverter\CurrencyConverter',
 *          'provider' => [
 *              'class' => 'imanilchaudhari\CurrencyConverter\Provider\CurrencyApi',
 *              'apiKey' => 'your-api-key',
 *          ],
 *      ],
 * ],
 * ```
 *
 * @see https://currencyapi.com/
 *
 * @author Anil Chaudhari <imanilchaudhari@gmail.com>
 * @since 1.0
 */
class CurrencyApi implements RateProviderInterface
{
    /**
     * The Currency API KEY
     *
     * @var string
     */
    public $apiKey;

    /**
     * Yii http client
     *
     * @var Client
     */
    private $_client;

    /**
     * Create a new provider instance.
     *
     * @param string $apiKey
     * @return void
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->_client = new Client([
            'baseUrl' => 'https://api.currencyapi.com',
            'transport' => 'yii\httpclient\CurlTransport',
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getRate($source, $target)
    {
        try {
            $response = $this->_client->get('/v3/latest', [
                'apikey' => $this->apiKey,
                'base_currency' => $source,
                'currencies' => $target
            ])->send();

            $content = $response->getData();

            if ($response->isOk && isset($content['data'][$target])) {
                return $content['data'][$target]['value'];
            }
            throw new InvalidConfigException($content['message']);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}
