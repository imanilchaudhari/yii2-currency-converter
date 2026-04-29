<?php

namespace imanilchaudhari\CurrencyConverter;

use yii\base\Behavior;
use yii\db\ActiveRecord;

class ProviderBehavior extends Behavior
{
    // ...

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
        ];
    }

    public function beforeValidate($event)
    {
        // ...
    }
}
