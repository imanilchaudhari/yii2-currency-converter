<?php

/**
 * @link https://github.com/imanilchaudhari
 * @copyright Copyright (c) 2024
 * @license [MIT License](https://opensource.org/license/mit)
 */

namespace imanilchaudhari\CurrencyConverter\Provider;

use yii\httpclient\Client;
use imanilchaudhari\CurrencyConverter\Interface\RateProviderInterface;
use yii\base\InvalidConfigException;

/**
 * Currency Layer provides currency conversion, current and historical forex exchange rate
 * and currency fluctuation data through REST API in json and xml formats compatible.
 *
 * To use CurrencylayerApi, configure your app component as below
 *
 * ```php
 *
 *  'components' => [
 *      'currencyConverter' => [
 *          'class' => 'imanilchaudhari\CurrencyConverter\CurrencyConverter',
 *          'provider' => [
 *              'class' => 'imanilchaudhari\CurrencyConverter\Provider\CurrencylayerApi',
 *              'access_key' => 'your-access-key',
 *          ],
 *      ],
 * ],
 * ```
 *
 * @see https://currencylayer.com/
 *
 * @author Anil Chaudhari <imanilchaudhari@gmail.com>
 * @since 1.0
 */
class CurrencylayerApi implements RateProviderInterface
{
    /**
     * The Api Layer access_key
     *
     * @var string
     */
    public $access_key;

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
            'baseUrl' => 'http://www.apilayer.net',
            'transport' => 'yii\httpclient\CurlTransport',
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getRate($source, $target)
    {
        try {
            $response = $this->_client->get('/api/live', [
                'access_key' => $this->access_key,
                'source' => $source,
                'curriences' => $target,
                'format' => 1
            ])->send();

            $content = $response->getData();
            if ($response->isOk && $content['success']) {
                return $content['rates'][$target];
            }
            throw new InvalidConfigException($content['error']['info']);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}
