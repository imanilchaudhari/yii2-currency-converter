<p align="center">
    <a href="imanilchaudhari/yii2-currency-converter" target="_blank">
        <img src="https://yiisoft.github.io/docs/images/yii_logo.svg" height="100px">
    </a>
    <h1 align="center">Yii2 Currency Converter</h1>
    <br>
</p>

[![Latest Stable Version](https://poser.pugx.org/imanilchaudhari/yii2-currency-converter/v)](https://packagist.org/packages/imanilchaudhari/yii2-currency-converter)
[![Total Downloads](https://poser.pugx.org/imanilchaudhari/yii2-currency-converter/downloads)](https://packagist.org/packages/imanilchaudhari/yii2-currency-converter)
[![Build Status](https://travis-ci.org/imanilchaudhari/yii2-currency-converter.svg?branch=master)](https://travis-ci.org/imanilchaudhari/yii2-currency-converter)
[![Code Coverage](https://codecov.io/gh/imanilchaudhari/yii2-currency-converter/branch/master/graph/badge.svg)](https://codecov.io/gh/imanilchaudhari/yii2-currency-converter)
[![StyleCI](https://github.styleci.io/repos/40206283/shield?branch=master)](https://github.styleci.io/repos/40206283?branch=master)
[![License](https://img.shields.io/github/license/imanilchaudhari/yii2-currency-converter)](//packagist.org/packages/imanilchaudhari/yii2-currency-converter)

This extension will help to find out current currency conversion rate using various providers.

Documentation is at [docs/README.md](docs/README.md).

Version 1 docs are located at [here](https://github.com/imanilchaudhari/yii2-currency-converter/tree/1.1).

Requirements
-----------
*   PHP version 7.4 or later
*   Curl Extension (Optional)


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist imanilchaudhari/yii2-currency-converter "3.1"
```

or add

```
"imanilchaudhari/yii2-currency-converter": "3.1"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, use it in your code by adding the below code on the config's components :
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
```
****and use as****

```
$rate = Yii::$app->currencyConverter->convert('USD', 'NPR');

```

***OR***

```php
use imanilchaudhari\CurrencyConverter\CurrencyConverter;
use imanilchaudhari\CurrencyConverter\Provider\ExchangeRatesApi;

$converter = new CurrencyConverter([
    'provider' => [
        'class' => ExchangeRatesApi::class,
    ],
]);
$rate =  $converter->convert('USD', 'NPR');

print_r($rate);  // it will print the current Nepalese currency (NPR) rate according to USD

```

Exchange Rate Providers
-----------------------
- [ApiForexApi](./src/Provider/ApiForexApi.php) - Get exchange rates from https://api.forex/
- [CurrencyApi](./src/Provider/CurrencyApi.php) - Get exchange rates from https://currencyapi.com/
- [CurrencyFreaksApi](./src/Provider/CurrencyFreaksApi.php) - Get exchange rates from https://currencyfreaks.com/
- [CurrencylayerApi](./src/Provider/CurrencylayerApi.php) - Get exchange rates from https://currencylayer.com/
- [ExchangeRatesApi](./src/Provider/ExchangeRatesApi.php) - Get exchange rates from https://www.exchangerate-api.com/ (Free, no billing required)
- [FixerApi](./src/Provider/FixerApi.php) - Get exchange rates from https://fixer.io/
- [OpenExchangeRatesApi](./src/Provider/OpenExchangeRatesApi.php) - Get exchange rates from https://openexchangerates.org/
- [UniRateApi](./src/Provider/UniRateApi.php) - Get exchange rates from https://unirateapi.com/ (Free, no credit card required.)

## Testing

### Unit testing

The package is tested with [PHPUnit](https://phpunit.de/). To run tests:

```shell
./vendor/bin/phpunit
```

## License

The Yii2 Currency Converter is free software. It is released under the terms of the MIT License. Please see [`LICENSE`](./LICENSE.md) for more information.


[![Powered by](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](https://www.yiiframework.com/)
