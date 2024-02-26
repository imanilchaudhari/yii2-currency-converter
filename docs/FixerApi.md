Fixer APi Integration
-----------------------------------
```php

use Yii;
use imanilchaudhari\CurrencyConverter\Provider\FixerApi;

class CurrencyConverter extends \imanilchaudhari\CurrencyConverter\CurrencyConverter
{
    /**
     * @inheritdoc
     */
    public function getRateProvider()
    {
        if (!$this->rateProvider) {
            $this->setRateProvider(new FixerApi());
        }

        return $this->rateProvider;
    }
}
```
