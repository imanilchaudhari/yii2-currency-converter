<?php

namespace imanilchaudhari\CurrencyConverter\Provider;

use yii\base\Component;

class FixerApi extends Component implements ProviderInterface
{
    /**
     * Url where Curl request is made
     *
     * @var string
     */
    const API_URL = 'http://api.fixer.io/latest?base=[fromCurrency]';

    /**
     * @inheritDoc
     */
    public function getRate($fromCurrency, $toCurrency)
    {
        $fromCurrency = urlencode($fromCurrency);
        
        $url = str_replace(['[fromCurrency]'], [$fromCurrency], static::API_URL);

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
