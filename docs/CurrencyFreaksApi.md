Currency Freaks APi Integration
-----------------------------------

CurrencyFreaks provides currency conversion, current and historical forex exchange rate and currency fluctuation data through REST API in json and xml formats compatible.

Source : [https://currencyfreaks.com](https://currencyfreaks.com/)

```php

'components' => [
    'currencyConverter' => [
        'class' => 'imanilchaudhari\CurrencyConverter\CurrencyConverter',
        'provider' => [
            'class' => 'imanilchaudhari\CurrencyConverter\Provider\CurrencyFreaksApi',
            'apiKey' => 'your-api-key',
        ],
    ],
],

$converter = Yii::$app->currencyConverter;
$rate =  $converter->convert('USD', 'NPR');
```
