Currency APi Integration
------------------------

The perfect tool to handle your exchange rate conversions. Our API helps you with current and historical foreign exchanges rates. Stop worrying about uptime & outdated data.

Source : [https://currencyapi.com](https://currencyapi.com/)

```php

'components' => [
    'currencyConverter' => [
        'class' => 'imanilchaudhari\CurrencyConverter\CurrencyConverter',
        'provider' => [
            'class' => 'imanilchaudhari\CurrencyConverter\Provider\CurrencyApi',
            'apiKey' => 'your-api-key',
        ],
    ],
],

$converter = Yii::$app->currencyConverter;
$rate =  $converter->convert('USD', 'NPR');
```
