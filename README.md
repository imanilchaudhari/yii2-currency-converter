Yii2 Currency Converter
=======================
Yii2 Currency Converter

Why Use It
-----------
*   Reliable Rate, Uses Yahoo API
*   Conversion without curreny code(from country code)
*   Caching of rate, to avoid connecting to Yahoo again and again ( Working on caching )

Requirements
-----------
*   PHP version 5.4 or later
*   Curl Extension (Optional)



Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist imanilchaudhari/yii2-currency-converter "*"
```

or add

```
"imanilchaudhari/yii2-currency-converter": "*"
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