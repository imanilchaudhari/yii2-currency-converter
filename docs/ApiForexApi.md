ApiForex APi Integration
------------------------

API Forex provide a worldwide API currencies converter.

Source : [https://api.forex](https://api.forex/)

```php

'components' => [
    'currencyConverter' => [
        'class' => 'imanilchaudhari\CurrencyConverter\CurrencyConverter',
        'provider' => [
            'class' => 'imanilchaudhari\CurrencyConverter\Provider\ApiForexApi',
            'apiKey' => 'your-api-key',
        ],
    ],
],

$converter = Yii::$app->currencyConverter;
$rate =  $converter->convert('USD', 'NPR');
```
