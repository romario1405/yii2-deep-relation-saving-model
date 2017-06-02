<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

$loader = require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../../vendor/yiisoft/yii2/Yii.php';
$loader->setPsr4('sonrac\\relations\\tests\\', __DIR__  . '/../../../tests');
\sonrac\relations\tests\application\boot\StartYii2Application::getInstance()->stop();
\sonrac\relations\tests\application\boot\StartYii2Application::getInstance()->start();
\sonrac\relations\tests\application\boot\StartSelenium::getInstance()->stop();
\sonrac\relations\tests\application\boot\StartSelenium::getInstance()->start();