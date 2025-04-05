<?php

/**
 * @link https://github.com/imanilchaudhari
 *
 * @copyright Copyright (c) 2024
 * @license [MIT License](https://opensource.org/license/mit)
 */

namespace imanilchaudhari\CurrencyConverter\Interface;

interface RateConverterInterface
{
    /**
     * Converts currency from one to another.
     *
     * @param array|string $source
     * @param array|string $target
     * @param int|float    $amount
     *
     * @return float
     */
    public function convert($source, $target, $amount = 1);
}
