<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\tabularWidgets\assets;

use yii\web\AssetBundle;

/**
 * Class DateTimeRangePickerAssets
 *
 * @see http://www.daterangepicker.com/ for more info
 *
 * @package sonrac\tabularWidgets\assets
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class DateTimeRangePickerAssets extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap-daterangepicker';

    public $js = [
        'daterangepicker.js',
    ];

    public $css = [
        'daterangepicker.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'sonrac\tabularWidgets\assets\MomentAsset',
    ];
}