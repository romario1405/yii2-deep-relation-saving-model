<?php
/**
 * Created by PhpStorm.
 * User: Donii Sergii
 * Date: 4/4/17
 * Time: 2:49 PM
 */

Yii::setAlias('@bower', __DIR__ . '/../../vendor/bower-asset');
$config = [
    'id'                  => 'test',
    'basePath'            => __DIR__ . '/../application',
    'runtimePath'         => __DIR__ . '/../_output',
    'vendorPath'          => __DIR__ . '/../../vendor',
    'components'          => [
        'db'      => require __DIR__ . '/../_db.php',
        'request' => [
            'cookieValidationKey' => 'tesfsdlkjdslgzhdfkljslkdfjslfjlksdf',
        ],
    ],
    'controllerNamespace' => 'sonrac\relations\tests\application\controllers',
];

return $config;