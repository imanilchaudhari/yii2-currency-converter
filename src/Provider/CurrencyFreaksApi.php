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
 * CurrencyFreaks provides currency conversion, current and historical forex exchange rate
 * and currency fluctuation data through REST API in json and xml formats compatible.
 *
 * To use CurrencyFreaksApi, configure your app component as below
 *
 * ```php
 *
 *  'components' => [
 *      'currencyConverter' => [
 *          'class' => 'imanilchaudhari\CurrencyConverter\CurrencyConverter',
 *          'provider' => [
 *              'class' => 'imanilchaudhari\CurrencyConverter\Provider\CurrencyFreaksApi',
 *              'apiKey' => 'your-api-key',
 *          ],
 *      ],
 * ],
 * ```
 *
 * @see https://currencyfreaks.com
 *
 * @author Anil Chaudhari <imanilchaudhari@gmail.com>
 * @since 1.0
 */
class CurrencyFreaksApi implements RateProviderInterface
{
    /**
     * The Currency Freaks API KEY
     *
     * @var string
     */
    public $apiKey;

    /**
     * Yii http client
     */
    private $_client;

    /**
     * Create a new provider instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_client = new Client([
            'baseUrl' => 'https://api.currencyfreaks.com',
            'transport' => 'yii\httpclient\CurlTransport',
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getRate($source, $target)
    {
        try {
            $response = $this->_client->get('/v2.0/rates/latest', [
                'apikey' => $this->apiKey,
                'base' => $source,
            ])->send();

            $content = $response->getData();

            if ($response->isOk) {
                return $content['rates'][$target];
            }
            throw new InvalidConfigException($content['message']);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}
