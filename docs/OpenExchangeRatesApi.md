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
