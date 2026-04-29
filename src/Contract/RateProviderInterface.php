<?php

/**
 * @link https://github.com/imanilchaudhari
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
     * @throws \Exception
     *
     * @return float
     */
    public function getRate($source, $target);
}
