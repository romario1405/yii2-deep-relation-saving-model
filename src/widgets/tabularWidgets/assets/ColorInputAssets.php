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
    public $sourcePath = '@bower/jquery-colorpicker';

    public $js = [
        'colorpicker.min.js',
    ];

    public $css = [
        'css/colorpicker.min.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}