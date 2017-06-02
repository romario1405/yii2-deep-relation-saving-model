<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\tabularWidgets\assets;

use yii\web\AssetBundle;

/**
 * Class CKEditorAssets
 *
 * @package sonrac\tabularWidgets\assets
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class ColorInputAssets extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/jquery-colorpicker';

    /**
     * @inheritdoc
     */
    public $js = [
        'colorpicker.min.js',
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        'css/colorpicker.min.css',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}