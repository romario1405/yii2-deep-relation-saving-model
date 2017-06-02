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
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/tinymce';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/tinymce/tinymce.min.js',
        'js/tinymce/jquery.tinymce.min.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}