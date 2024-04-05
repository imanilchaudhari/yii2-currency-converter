Open Exchange Rates APi Integration
-----------------------------------

Open Exchange Rates provides currency conversion, current and historical forex exchange rate and currency fluctuation data through REST API in json and xml formats compatible.

Source : [https://openexchangerates.org](https://openexchangerates.org/)

```php

'components' => [
    'currencyConverter' => [
        'class' => 'imanilchaudhari\CurrencyConverter\CurrencyConverter',
        'provider' => [
            'class' => 'imanilchaudhari\CurrencyConverter\Provider\OpenExchangeRatesApi',
            'appId' => 'your-app-id',
        ],
    ],
],

$converter = Yii::$app->currencyConverter;
$rate =  $converter->convert('USD', 'NPR');
```
