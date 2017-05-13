<?php
// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
$loader = require(__DIR__ . '/../../../vendor/autoload.php');
require(__DIR__ . '/../../../vendor/yiisoft/yii2/Yii.php');
$config = require(__DIR__ . '/../../acceptance/_config.php');
$additional = [
    'components' => [
        'request' => [
            'cookieValidationKey' => 'sdfogjsldfk.gjlksdfjglsdfjglsdfjg;lsdfj',

        ],
    ]
];
$loader->setPsr4('sonrac\\relations\\tests\\', __DIR__ . '/../../');
(new yii\web\Application(\yii\helpers\ArrayHelper::merge($config, $additional)))->run();