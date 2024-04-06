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
 * Exchange Rates provides currency conversion, current and historical forex exchange rate
 * and currency fluctuation data through REST API in json and xml formats compatible.
 *
 * To use ExchangeRatesApi, configure your app component as below
 *
 * ```php
 *
 *  'components' => [
 *      'currencyConverter' => [
 *          'class' => 'imanilchaudhari\CurrencyConverter\CurrencyConverter',
 *          'provider' => [
 *              'class' => 'imanilchaudhari\CurrencyConverter\Provider\ExchangeRatesApi',
 *          ],
 *      ],
 * ],
 * ```
 *
 * @see https://www.exchangerate-api.com/
 *
 * @author Anil Chaudhari <imanilchaudhari@gmail.com>
 * @since 1.0
 */
class ExchangeRatesApi implements RateProviderInterface
{
    /**
     * Yii http client
     *
     * @var Client
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
            'baseUrl' => 'https://open.er-api.com',
            'transport' => 'yii\httpclient\CurlTransport',
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getRate($source, $target)
    {
        try {
            $response = $this->_client->get("/v6/latest/$source")->send();
            $content = $response->getData();
            if ($response->isOk && ($content['result'] == 'success')) {
                return $content['rates'][$target];
            }
            throw new InvalidConfigException($content['message']);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}
