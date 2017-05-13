<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\relations\assets;

use yii\web\AssetBundle;

/**
 * Class JQueryRepeaterAsset
 *
 * @package sonrac\relations\assets
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class JQueryRepeaterAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery.repeater';

    public $js = [
        'jquery.repeater.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        parent::init();

        if (YII_DEBUG) {
            $this->js[0] = 'jquery.repeater.js';
        }
    }
}