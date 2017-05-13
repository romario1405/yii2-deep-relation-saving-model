<?php
/**
 * Created by PhpStorm.
 * User: Donii Sergii
 * Date: 4/14/17
 * Time: 5:27 PM
 */

namespace sonrac\relations\tests\application\boot;

/**
 * Class StartSelenium
 * Start selenium server
 *
 * @package sonrac\ConfigFormatter\Tests\functional
 */
class StartYii2Application extends StartSelenium
{

    protected static $_instance;

    /**
     * StartSelenium constructor.
     *
     * @param null|string $command Command
     * @param null|string $outFile Log file path
     * @param null|string $pidFile Yii2 application server pid file path
     */
    protected function __construct($command = null, $outFile = null, $pidFile = null)
    {
        // php -t tests/application/web  -S localhost:9331
        $command = $command ?? 'php -t ' . __DIR__ . '/../web -S localhost:9550';
        $outFile = $outFile ?? __DIR__ . '/yii2-app.out';
        $pidFile = $pidFile ?? __DIR__ . '/yii2-app.pid';

        parent::__construct($command, $outFile, $pidFile);
    }

    /**
     * Get instance of start selenium object
     *
     * @param null|string $command Command
     * @param null|string $outFile Log file path
     * @param null|string $pidFile Selenium server pid file path
     *
     * @return \sonrac\relations\tests\application\boot\StartSelenium
     */
    public static function getInstance($command = null, $outFile = null, $pidFile = null)
    {
        return static::$_instance ?? (static::$_instance = new static($command, $outFile, $pidFile));
    }
}