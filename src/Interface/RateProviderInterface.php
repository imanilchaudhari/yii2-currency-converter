<?php

/**
 * @link https://github.com/imanilchaudhari
 * @copyright Copyright (c) 2024
 * @license [MIT License](https://opensource.org/license/mit)
 */

namespace imanilchaudhari\CurrencyConverter\Interface;

interface RateProviderInterface
{
    /**
     * Gets exchange rate from cache
     *
     * @param  string $sourceCurrency
     * @param  string $targetCurrency
     * @return float
     */
    public function getRate($sourceCurrency, $targetCurrency);
}