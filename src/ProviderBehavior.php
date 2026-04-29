<?php

namespace imanilchaudhari\CurrencyConverter;

use yii\db\ActiveRecord;
use yii\base\Behavior;

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
