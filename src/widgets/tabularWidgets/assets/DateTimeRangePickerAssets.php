<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\tabularWidgets\assets;

use yii\web\AssetBundle;

/**
 * Class DateTimeRangePickerAssets
 *
 * @see     http://www.daterangepicker.com/ for more info
 *
 * @package sonrac\tabularWidgets\assets
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class DateTimeRangePickerAssets extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/bootstrap-daterangepicker';

    /**
     * @inheritdoc
     */
    public $js = [
        'daterangepicker.js',
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        'daterangepicker.css',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'sonrac\tabularWidgets\assets\MomentAsset',
    ];
}