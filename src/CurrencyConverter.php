<?php

namespace imanilchaudhari\CurrencyConverter;

use Yii;
use InvalidArgumentException;
use imanilchaudhari\CurrencyConverter\Provider;
use imanilchaudhari\CurrencyConverter\Interface\RateConverterInterface;
use imanilchaudhari\CurrencyConverter\Interface\RateProviderInterface;

class CurrencyConverter implements RateConverterInterface
{
    /**
     * @var RateProviderInterface
     */
    protected $rateProvider;

    /**
     * {@inheritDoc}
     */
    public function convert($source, $target, $amount = 1)
    {
        $cache = Yii::$app->cache;

        $sourceCurrency = $this->parseCurrencyArgument($source);
        $targetCurrency = $this->parseCurrencyArgument($target);

        if ($cache) {
            if ($rate = $cache->get($sourceCurrency . '_ ' . $targetCurrency . '_cache')) {
                return $rate * $amount;
            } elseif ($rate = $cache->get($targetCurrency . '_ ' . $sourceCurrency . '_cache')) {
                return (1 / $rate) * $amount;
            }
        }

        $rate = $this->getRateProvider()->getRate($sourceCurrency, $targetCurrency);

        if ($cache) {
            $cache->set($sourceCurrency . '_ ' . $targetCurrency . '_cache', $rate);
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
        if (!$this->rateProvider) {
            $this->setRateProvider(new Provider\YahooApi());
        }

        return $this->rateProvider;
    }

    /**
     * Sets rate provider
     *
     * @param RateProviderInterface $rateProvider
     *
     * @return self
     */
    public function setRateProvider(RateProviderInterface $rateProvider)
    {
        $this->rateProvider = $rateProvider;

        return $this;
    }

    /**
     * Parses the Currency Arguments
     *
     * @param string|array $data
     * @return string
     * @throws Exception\InvalidArgumentException
     */
    protected function parseCurrencyArgument($data)
    {
        if (is_string($data)) {
            $currency = $data;
        } elseif (is_array($data)) {
            if (isset($data['country'])) {
                $currency = CountryToCurrency::getCurrency($data['country']);
            } elseif (isset($data['currency'])) {
                $currency = $data['currency'];
            } else {
                throw new InvalidArgumentException('Please provide country or currency!');
            }
        } else {
            throw new InvalidArgumentException('Invalid currency provided. String or array expected.');
        }

        return $currency;
    }
}
