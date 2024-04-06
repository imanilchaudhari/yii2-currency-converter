<?php

/**
 * @link https://github.com/imanilchaudhari
 * @copyright Copyright (c) 2024
 * @license [MIT License](https://opensource.org/license/mit)
 */

namespace imanilchaudhari\CurrencyConverter;

use Yii;
use yii\helpers\Json;
use yii\base\Component;
use yii\base\InvalidArgumentException;
use imanilchaudhari\CurrencyConverter\Interface\RateConverterInterface;
use imanilchaudhari\CurrencyConverter\Interface\RateProviderInterface;

/**
 * Once the extension is installed, simply use it in your code by  :
 * ```php
 * 'components' => [
 *     'currencyConverter' => [
 *         'class' => 'imanilchaudhari\CurrencyConverter\CurrencyConverter',
 *         'provider' => [
 *             'class' => 'imanilchaudhari\CurrencyConverter\Provider\ExchangeRatesApi',
 *         ],
 *     ],
 *     ...
 * ],
 *
 * $converter = Yii::$app->currencyConverter;
 * $rate =  $converter->convert('USD', 'NPR');
 *
 * ```
 *
 * @author Anil Chaudhari <imanilchaudhari@gmail.com>
 * @since 1.0
 */
class CurrencyConverter extends Component implements RateConverterInterface
{
    /**
     * Cache duration
     *
     * @var int $duration
     */
    public $duration = 3600;

    /**
     * @var array object configuration.
     */
    public $provider = [
        'class' => 'imanilchaudhari\CurrencyConverter\Provider\ExchangeRatesApi'
    ];

    /**
     * @var RateProviderInterface
     */
    private $_provider;

    /**
     * {@inheritDoc}
     */
    public function convert($source, $target, $amount = 1)
    {
        $cache = Yii::$app->cache;

        $sourceCurrency = is_array($source) ? $this->parseCurrencyArgument($source) : $source;
        $targetCurrency = is_array($source) ? $this->parseCurrencyArgument($target) : $target;

        if ($cache) {
            if ($rate = $cache->get($sourceCurrency . '_ ' . $targetCurrency . '_cache')) {
                return $rate * $amount;
            } elseif ($rate = $cache->get($targetCurrency . '_ ' . $sourceCurrency . '_cache')) {
                return (1 / $rate) * $amount;
            }
        }

        $rate = $this->getRateProvider()->getRate($sourceCurrency, $targetCurrency);

        if ($cache) {
            $cache->set($sourceCurrency . '_ ' . $targetCurrency . '_cache', $rate, $this->duration);
        }

        return $rate * $amount;
    }

    /**
     * Gets Rate Provider
     *
     * @return RateProviderInterface
     */
    public function getRateProvider()
    {
        if ($this->_provider instanceof RateProviderInterface) {
            return $this->_provider;
        }
        return $this->setRateProvider($this->provider);
    }

    /**
     * Sets rate provider from its array configuration.
     *
     * @param array $config rate provider instance configuration.
     * @return RateProviderInterface rate provider instance.
     */
    protected function setRateProvider($config)
    {
        return $this->_provider = Yii::createObject($config);
    }

    /**
     * Parses the Currency Arguments
     *
     * @param array $data
     * @return string
     * @throws InvalidArgumentException
     */
    protected function parseCurrencyArgument($data)
    {
        if (isset($data['country'])) {
            $currency = $this->getCurrencyCode($data['country']);
        } elseif (isset($data['currency'])) {
            $currency = $data['currency'];
        } else {
            throw new InvalidArgumentException('Please provide country or currency!');
        }

        return $currency;
    }

    /**
     * Gets Currency code by Country code
     *
     * @param  string $countryCode Country code
     * @return string
     * @throws InvalidArgumentException
     */
    protected function getCurrencyCode($countryCode)
    {
        $currencies = Json::decode(file_get_contents(__DIR__ . '/resources/codes.json'), true);
        if (!array_key_exists($countryCode, $currencies)) {
            throw new InvalidArgumentException(sprintf('Unsupported country code, %s', $countryCode));
        }

        return $currencies[$countryCode];
    }
}
