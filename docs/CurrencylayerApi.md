Currencylayer APi Integration
-----------------------------------
```php

use Yii;
use imanilchaudhari\CurrencyConverter\Provider\CurrencylayerApi;

class CurrencyConverter extends \imanilchaudhari\CurrencyConverter\CurrencyConverter
{
    /**
     * @inheritdoc
     */
    public function getRateProvider()
    {
        if (!$this->rateProvider) {
            $this->setRateProvider(new CurrencylayerApi([
                'access_key' => Yii::$app->params['currencylayer']['access_key'],
            ]));
        }

        return $this->rateProvider;
    }
}
```
