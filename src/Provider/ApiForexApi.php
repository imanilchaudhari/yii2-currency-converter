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
 * API Forex provide a worldwide API currencies converter.
 *
 * To use ApiForexApi, configure your app component as below
 *
 * ```php
 *
 *  'components' => [
 *      'currencyConverter' => [
 *          'class' => 'imanilchaudhari\CurrencyConverter\CurrencyConverter',
 *          'provider' => [
 *              'class' => 'imanilchaudhari\CurrencyConverter\Provider\ApiForexApi',
 *              'apiKey' => 'your-api-key',
 *          ],
 *      ],
 * ],
 * ```
 *
 * @see https://api.forex
 *
 * @author Anil Chaudhari <imanilchaudhari@gmail.com>
 * @since 1.0
 */
class ApiForexApi implements RateProviderInterface
{
    /**
     * The Api Forex apiKey
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
            'baseUrl' => 'https://v2.api.forex',
            'transport' => 'yii\httpclient\CurlTransport',
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getRate($source, $target)
    {
        try {
            $response = $this->_client->get('/rates/latest.json', [
                'key' => $this->apiKey,
                'base' => $source,
            ])->send();

            $content = $response->getData();

            if ($response->isOk && $content['success']) {
                if (isset($content['rates'][$target])) {
                    return $content['rates'][$target];
                }
                throw new \Error("Api forex does not support $target currency.");
            }
            throw new InvalidConfigException($content['error']['message']);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}
