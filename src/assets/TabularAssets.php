<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\relations\assets;

use yii\web\AssetBundle;

/**
 * Class TabularAssets
 * Tabular assets
 *
 * @property bool $registerCss Register css files flag switcher
 *
 * @package sonrac\relations\assets
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class TabularAssets extends AssetBundle
{
    /**
     * Source assets path
     *
     * @var string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $sourcePath = __DIR__ . '/tabular/build';

    /**
     * JS files
     *
     * @var array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $js = [
        'js/tabular.min.js',
    ];

    /**
     * Css files
     *
     * @var array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $css = [
        'css/tabular.min.css',
    ];

    /**
     * Register css files
     *
     * @var bool
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $registerCss = true;

    public $depends = [
        'yii\web\YiiAsset',
        'sonrac\relations\assets\JQueryRepeaterAsset',
    ];

    /**
     * Init object
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function init()
    {
        parent::init();

        if (YII_DEBUG) {
            $this->js[0] = 'js/tabular.js';
            $this->css[0] = 'css/tabular.css';
        }

        if (!$this->registerCss) {
            $this->registerCss = [];
        }
    }
}