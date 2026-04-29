<?php

error_reporting(-1);

require_once dirname(__DIR__).'/vendor/autoload.php';
require_once dirname(__DIR__).'/vendor/yiisoft/yii2/Yii.php';

new \yii\console\Application([
    'id'          => 'test',
    'basePath'    => dirname(__DIR__),
    'vendorPath'  => dirname(__DIR__).'/vendor',
    'runtimePath' => sys_get_temp_dir(),
]);
