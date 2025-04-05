<?php

/**
 * @link https://github.com/imanilchaudhari
 *
 * @copyright Copyright (c) 2025
 * @license [MIT License](https://opensource.org/license/mit)
 */

namespace imanilchaudhari\CurrencyConverter\Provider;

use yii\httpclient\Client;
use yii\base\InvalidConfigException;
use imanilchaudhari\CurrencyConverter\Interface\RateProviderInterface;

/**
 * UniRate API, Access 593 real-time currency exchange rates with our completely free API. No credit card required..
 *
 * To use UniRateApi, configure your app component as below
 *
 * ```php
 *
 *  'components' => [
 *      'currencyConverter' => [
 *          'class' => 'imanilchaudhari\CurrencyConverter\CurrencyConverter',
 *          'provider' => [
 *              'class' => 'imanilchaudhari\CurrencyConverter\Provider\UniRateApi',
 *              'apiKey' => 'your-api-key',
 *          ],
 *      ],
 * ],
 * ```
 *
 * @see https://unirateapi.com/
 *
 * @author Anil Chaudhari <imanilchaudhari@gmail.com>
 *
 * @since 3.2
 */
class UniRateApi implements RateProviderInterface
{
    /**
     * UniRate Currency API KEY.
     *
     * @var string
     */
    public $apiKey;

    /**
     * Yii http client.
     *
     * @var Client
     */
    private $_client;

    /**
     * Create a new provider instance.
     *
     * @param string $apiKey
     *
     * @return void
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->_client = new Client([
            'baseUrl'   => 'https://api.unirateapi.com',
            'transport' => 'yii\httpclient\CurlTransport',
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getRate($source, $target)
    {
        try {
            $response = $this->_client->get('/api/convert', [
                'api_key' => $this->apiKey,
                'from'    => $source,
                'to'      => $target,
            ])->send();

            $content = $response->getData();

            if ($response->isOk) {
                return $content['result'];
            }

            throw new InvalidConfigException($content['error']);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}
