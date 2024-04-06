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
 * Fixer provides currency conversion, current and historical forex exchange rate
 * and currency fluctuation data through REST API in json and xml formats compatible.
 *
 * To use FixerApi, configure your app component as below
 *
 * ```php
 *
 *  'components' => [
 *      'currencyConverter' => [
 *          'class' => 'imanilchaudhari\CurrencyConverter\CurrencyConverter',
 *          'provider' => [
 *              'class' => 'imanilchaudhari\CurrencyConverter\Provider\FixerApi',
 *              'access_key' => 'your-access-key',
 *          ],
 *      ],
 * ],
 * ```
 *
 * @see https://fixer.io/
 *
 * @author Anil Chaudhari <imanilchaudhari@gmail.com>
 * @since 1.0
 */
class FixerApi implements RateProviderInterface
{
    /**
     * The Fixer Api access_key
     *
     * @var string
     */
    public $access_key;

    /**
     * Yii http client
     *
     * @var Client
     */
    private $_client;

    /**
     * Create a new provider instance.
     *
     * @param string $access_key
     * @return void
     */
    public function __construct($access_key)
    {
        $this->access_key = $access_key;
        $this->_client = new Client([
            'baseUrl' => 'https://data.fixer.io',
            'transport' => 'yii\httpclient\CurlTransport',
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getRate($source, $target)
    {
        try {
            $response = $this->_client->get('/api/latest', [
                'access_key' => $this->access_key,
                'base' => $source,
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
