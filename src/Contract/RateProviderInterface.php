<?php

/**
 * @see https://github.com/imanilchaudhari
 *
 * @copyright Copyright (c) 2024
 * @license [MIT License](https://opensource.org/license/mit)
 */

namespace imanilchaudhari\CurrencyConverter\Contract;

interface RateProviderInterface
{
    /**
     * Gets exchange rate from provider.
     *
     * @param string $source
     * @param string $target
     *
     * @return float
     *
     * @throws \Exception
     */
    public function getRate($source, $target);
}
