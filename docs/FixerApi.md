Fixer APi Integration
-----------------------------------

Fixer provides currency conversion, current and historical forex exchange rate and currency fluctuation data through REST API in json and xml formats compatible.

Source : [https://fixer.io](https://fixer.io/)

```php

'components' => [
    'currencyConverter' => [
        'class' => 'imanilchaudhari\CurrencyConverter\CurrencyConverter',
        'provider' => [
            'class' => 'imanilchaudhari\CurrencyConverter\Provider\FixerApi',
            'access_key' => 'your-access-key',
        ],
    ],
],

$converter = Yii::$app->currencyConverter;
$rate =  $converter->convert('USD', 'NPR');
```
