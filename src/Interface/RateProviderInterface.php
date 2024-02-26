<?php

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
