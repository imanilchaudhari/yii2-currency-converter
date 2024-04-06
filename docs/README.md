# Yii2 Currency Converter

This package provides the most famous currency rates providers' implementations. The package was originally built on Yahoo API, but there was a discontinuation of it. It is therefore highly recommended that you make use of only active providers, such as the ones listed below.

Usage
-----

Once the extension is installed, simply use it in your code by  :
```php
'components' => [
    'currencyConverter' => [
        'class' => 'imanilchaudhari\CurrencyConverter\CurrencyConverter',
        'provider' => [
            'class' => 'imanilchaudhari\CurrencyConverter\Provider\ExchangeRatesApi',
        ],
    ],
    ...
],

$converter = Yii::$app->currencyConverter;
$rate =  $converter->convert('USD', 'NPR');

```

***OR***

```php
use imanilchaudhari\CurrencyConverter\CurrencyConverter;
use imanilchaudhari\CurrencyConverter\Provider\OpenExchangeRatesApi;

$converter = new CurrencyConverter([
    'provider' => [
        'class' => OpenExchangeRatesApi::class,
        'appId' => Yii::$app->params['openExchangeRate']['appId'],
    ],
]);
$rate =  $converter->convert('USD', 'NPR');

print_r($rate);  // it will print current Nepalese currency (NPR) rate according to USD

```

Active Providers
-----------------------
- [ApiForex API](ApiForexApi.md) - Get exchange rates from https://api.forex/
- [Currency API](CurrencyApi.md) - Get exchange rates from https://currencyapi.com/
- [CurrencyFreaks API](CurrencyFreaksApi.md) - Get exchange rates from https://currencyfreaks.com/
- [Currency Layer API](CurrencylayerApi.md) - Get exchange rates from https://currencylayer.com/
- [Exchange Rates API](ExchangeRatesApi.md) - Get exchange rates from https://www.exchangerate-api.com/
- [Fixer API](FixerApi.md) - Get exchange rates from https://fixer.io/
- [Open Exchange Rates API](OpenExchangeRatesApi.md) - Get exchange rates from https://openexchangerates.org/

