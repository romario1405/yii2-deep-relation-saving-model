<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\tabularWidgets\assets;

use yii\web\AssetBundle;

/**
 * Class TinyMCEAsset
 *
 * @package sonrac\tabularWidgets\assets
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class TinyMCEAsset extends AssetBundle
{
    public $sourcePath = '@bower/tinymce';

    public $js = [
        'js/tinymce/tinymce.min.js',
        'js/tinymce/jquery.tinymce.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}