<?php

namespace imanilchaudhari\CurrencyConverter\Provider;

use imanilchaudhari\CurrencyConverter\Interface\RateProviderInterface;

class CurrencylayerApi implements RateProviderInterface
{
    /**
     * Url where Curl request is made
     *
     * @var string
     */
    const API_URL = 'http://www.apilayer.net/api/live?access_key=[access_key]&source=[fromCurrency]&curriences=[toCurrency]&format=1';

    /**
     * The Api Layer access_key
     *
     * @var string
     */
    public $access_key;

    /**
     * @inheritDoc
     */
    public function getRate($fromCurrency, $toCurrency)
    {
        $fromCurrency = urlencode($fromCurrency);
        $toCurrency = urlencode($toCurrency);

        $url = str_replace(['[access_key]', '[fromCurrency]', '[toCurrency]'], [$this->access_key, $fromCurrency, $toCurrency], static::API_URL);

        $ch = curl_init();
        $timeout = 0;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $rawdata = curl_exec($ch);
        curl_close($ch);

        $parsedData = json_decode($rawdata, true);

        return $parsedData['rates'][strtoupper($toCurrency)];
    }
}
