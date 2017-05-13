<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\tabularWidgets\assets;

use yii\web\AssetBundle;

/**
 * Class DateTimeRangePickerAssets
 *
 * @package sonrac\tabularWidgets\assets
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class DateTimePickerAssets extends AssetBundle
{
    public $sourcePath = '@bower/eonasdan-bootstrap-datetimepicker/build';

    public $js = [
        'js/bootstrap-datetimepicker.min.js',
    ];

    public $css = [
        'css/bootstrap-datetimepicker.min.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'sonrac\tabularWidgets\assets\MomentAsset',
    ];
}