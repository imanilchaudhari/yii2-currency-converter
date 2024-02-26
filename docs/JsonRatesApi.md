Json Rates APi Integration
-----------------------------------
```php

use Yii;
use imanilchaudhari\CurrencyConverter\Provider\JsonRatesApi;

class CurrencyConverter extends \imanilchaudhari\CurrencyConverter\CurrencyConverter
{
    /**
     * @inheritdoc
     */
    public function getRateProvider()
    {
        if (!$this->rateProvider) {
            $this->setRateProvider(new JsonRatesApi());
        }

        return $this->rateProvider;
    }
}
```
