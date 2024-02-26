<?php

namespace imanilchaudhari\CurrencyConverter\Provider;

use imanilchaudhari\CurrencyConverter\Interface\RateProviderInterface;

class YahooApi implements RateProviderInterface
{
    /**
     * Url where Curl request is made
     *
     * @var string
     */
    const API_URL = 'http://download.finance.yahoo.com/d/quotes.csv?s=[fromCurrency][toCurrency]=X&f=nl1d1t1';

    /**
     * {@inheritDoc}
     */
    public function getRate($fromCurrency, $toCurrency)
    {
        $fromCurrency = urlencode($fromCurrency);
        $toCurrency = urlencode($toCurrency);

        $url = str_replace(
            ['[fromCurrency]', '[toCurrency]'],
            [$fromCurrency, $toCurrency],
            static::API_URL
        );

        $ch = curl_init();
        $timeout = 0;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $rawdata = curl_exec($ch);
        curl_close($ch);

        return explode(',', $rawdata)[1];
    }
}
