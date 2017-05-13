<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\relations\tests\application\assets;

use yii\web\AssetBundle;

/**
 * Class BootstrapAsset
 *
 * @package sonrac\relations\tests\application\assets
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class BootstrapAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/bootstrap';

    public $js = [
        'js/bootstrap.min.js',
    ];

    public $css = [
        'css/bootstrap.min.css'
    ];
}