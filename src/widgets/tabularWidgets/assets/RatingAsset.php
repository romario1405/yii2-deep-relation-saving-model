<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\tabularWidgets\assets;

use yii\web\AssetBundle;

/**
 * Class RatingAsset
 *
 * @package sonrac\tabularWidgets\assets
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class RatingAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-bar-rating/dist';

    public $js = [
        'jquery.barrating.min.js',
    ];

    public $css = [
        'themes/bootstrap-stars.css',
    ];
}