<?php

namespace imanilchaudhari\CurrencyConverter\Interface;

interface RateConverterInterface
{
    /**
     * Converts currency from one to another
     *
     * @param array|string   $source
     * @param array|string   $target
     * @param float optional $amount
     *
     * @return float
     */
    public function convert($source, $target, $amount = 1);
}
