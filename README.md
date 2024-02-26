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
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fyiisoft%2F_____%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/imanilchaudhari/yii2-currency-converter/master)
[![type-coverage](https://shepherd.dev/github/imanilchaudhari/yii2-currency-converter/coverage.svg)](https://shepherd.dev/github/imanilchaudhari/yii2-currency-converter)
[![psalm-level](https://shepherd.dev/github/imanilchaudhari/yii2-currency-converter/level.svg)](https://shepherd.dev/github/imanilchaudhari/yii2-currency-converter)

This extension will help to find out current currency conversion rate. This extension uses Yahoo's currency conversion API.

Why Use It
-----------
*   Reliable Rate. Uses Yahoo API, Open Exchange Rates API.
*   Conversion without curreny code (from country code).
*   Caching of rate, to avoid connecting to Yahoo again and again.

Important Notice
----------------
As of recent changes on Yahoo Terms of Service. As such, the service is being discontinued. I highly recommend you to use [Open Exchange Rates API](http://openexchangerates.org/). As suggested by [chaimleich](https://github.com/chaimleich) on this [pull request](https://github.com/imanilchaudhari/yii2-currency-converter/pull/3). You can find Open Exchnage Rates working example below.

Requirements
-----------
*   PHP version 7.4 or later
*   Curl Extension (Optional)



Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist imanilchaudhari/yii2-currency-converter "2.0"
```

or add

```
"imanilchaudhari/yii2-currency-converter": "2.0"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
use Yii;
use imanilchaudhari\CurrencyConverter\CurrencyConverter;

$converter = new CurrencyConverter();
$rate =  $converter->convert('USD', 'NPR');

print_r($rate);  // it will print current Nepalese currency (NPR) rate according to USD


```

Available Currency Codes
-----------------------
```php
$currencies = [
        'AF' => 'AFA',
        'AL' => 'ALL',
        'DZ' => 'DZD',
        'AS' => 'USD',
        'AD' => 'EUR',
        ...
    ];

```

Note: to view all the applicable currencies [click here](https://github.com/imanilchaudhari/yii2-currency-converter/blob/1.1/CountryToCurrency.php).

Contributors
-------
* [Robot72](https://github.com/Robot72 "Robot72")
* [chaimleich](https://github.com/chaimleich "chaimleich")

Open Exchange Rates APi Integration
-----------------------------------
Here is a code snippets suggested by [chaimleich](https://github.com/chaimleich) on [this pull request](https://github.com/imanilchaudhari/yii2-currency-converter/pull/3).
```php

use Yii;
use imanilchaudhari\CurrencyConverter\Provider\OpenExchangeRatesApi;

class CurrencyConverter extends \imanilchaudhari\CurrencyConverter\CurrencyConverter
{
    /**
     * @inheritdoc
     */
    public function getRateProvider()
    {
        if (!$this->rateProvider) {
            $this->setRateProvider(new OpenExchangeRatesApi([
                'appId' => Yii::$app->params['openExchangeRate']['appId'],
            ]));
        }

        return $this->rateProvider;
    }
}
```

