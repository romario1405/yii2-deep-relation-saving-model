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
class StartSelenium
{
    /**
     * Instance of \sonrac\ConfigFormatter\Tests\functional\StartSelenium
     *
     * @var static
     */
    protected static $_instance = null;
    /**
     * Command for run selenium server
     *
     * @var string
     */
    protected $_command;
    /**
     * Output start selenium server log file path
     *
     * @var string
     */
    protected $_outputFile;
    /**
     * File path for save pid selenium server process
     *
     * @var string
     */
    protected $_pidFile;

    /**
     * StartSelenium constructor.
     *
     * @param null|string $command Command
     * @param null|string $outFile Log file path
     * @param null|string $pidFile Selenium server pid file path
     */
    protected function __construct($command = null, $outFile = null, $pidFile = null)
    {
        $this->_command    = $command ?? 'java -Dwebdriver.chrome.driver=' . __DIR__ . '/chromedriver -jar ' . __DIR__ . '/selenium-server-standalone-3.3.1.jar';
        $this->_outputFile = $outFile ?? __DIR__ . '/selenium.out';
        $this->_pidFile    = $pidFile ?? __DIR__ . '/selenium.pid';
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

    /**
     * Start selenium server
     *
     * @return void
     */
    public function start()
    {
        $command = sprintf("%s > %s 2>&1 & echo $! >> %s", $this->_command, $this->_outputFile, $this->_pidFile);
        system($command);
    }

    /**
     * Stop selenium server
     *
     * @return void
     */
    public function stop()
    {
        $data = file_exists($this->_pidFile) ? trim(file_get_contents($this->_pidFile)) : null;
        if (file_exists($this->_pidFile)) {
            unlink($this->_pidFile);
        }

        if (file_exists($this->_outputFile)) {
            unlink($this->_outputFile);
        }

        if ($data) {
            $data = explode(PHP_EOL, $data);

            foreach ($data as $datum) {
                $datum = trim($datum);
                if (($datum = ((int)$datum)) && $datum && !empty($datum) && ((is_file("/proc/{$datum}")) || is_dir("/proc/{$datum}"))) {
                    @exec("kill {$datum}");
                }
            }

        }
    }
}