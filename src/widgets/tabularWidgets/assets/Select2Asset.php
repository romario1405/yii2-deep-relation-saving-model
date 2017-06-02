<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\tabularWidgets\assets;

use yii\web\AssetBundle;

/**
 * Class Select2Asset
 * Select2 widget asset
 *
 * @package sonrac\tabularWidgets\assets
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class Select2Asset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/select2/dist';

    /**
     * @inheritdoc
     */
    public $css = [
        'css/select2.min.css',
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'js/select2.full.min.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset',
    ];
}