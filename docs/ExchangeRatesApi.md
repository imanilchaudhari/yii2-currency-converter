Exchange Rates APi Integration
-----------------------------------

Exchange Rates provides currency conversion, current and historical forex exchange rate and currency fluctuation data through REST API in json and xml formats compatible.

Source : [https://www.exchangerate-api.com](https://www.exchangerate-api.com/)

```php

'components' => [
    'currencyConverter' => [
        'class' => 'imanilchaudhari\CurrencyConverter\CurrencyConverter',
        'provider' => [
            'class' => 'imanilchaudhari\CurrencyConverter\Provider\ExchangeRatesApi',
        ],
    ],
],

$converter = Yii::$app->currencyConverter;
$rate =  $converter->convert('USD', 'NPR');
```
