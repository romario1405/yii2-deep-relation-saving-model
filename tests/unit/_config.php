<?php
/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 4/3/17
 * Time: 21:10
 *
 * @author Doniy Serhey <doniysa@gmail.com>
 */
Yii::setAlias('@tests', __DIR__ . '/../');

use sonrac\relations\tests\application\boot\Boot;

return [
    'id'          => 'test',
    'basePath'    => __DIR__ . '/../../tests',
    'runtimePath' => __DIR__ . '/../../tests/_output',
    'bootstrap'   => [Boot::class],
    'components'  => [
        'db' => require __DIR__ . '/../_db.php',
    ],
];