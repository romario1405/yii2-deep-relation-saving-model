<?php
/**
 * Created by PhpStorm.
 * User: Donii Sergii
 * Date: 4/4/17
 * Time: 2:49 PM
 */

Yii::setAlias('@bower', __DIR__ . '/../../vendor/bower-asset');

return [
    'id'                  => 'test',
    'basePath'            => __DIR__ . '/../../tests/application',
    'runtimePath'         => __DIR__ . '/../../tests/_output',
    'vendorPath'          => __DIR__ . '/../../vendor',
    'components'          => [
        'db'      => require __DIR__ . '/../_db.php',
        'request' => [
            'cookieValidationKey' => 'asdasdasd',
        ],
    ],
    'controllerNamespace' => 'sonrac\relations\tests\application\controllers',
];