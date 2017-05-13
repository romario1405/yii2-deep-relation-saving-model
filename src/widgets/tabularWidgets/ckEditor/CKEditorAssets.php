<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\tabularWidgets\ckEditor;

use yii\web\AssetBundle;

/**
 * Class CKEditorAssets
 *
 * @package sonrac\tabularWidgets\assets
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class CKEditorAssets extends AssetBundle
{
    public $sourcePath = '@bower/ckeditor';

    public $js = [
        'ckeditor.js',
        'styles.js',
    ];

    public $css = [
        'contents.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}