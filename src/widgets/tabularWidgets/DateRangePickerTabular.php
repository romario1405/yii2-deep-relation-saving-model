<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\tabularWidgets;

use yii\web\JsExpression;

/**
 * Class DateTimePickerTabular
 *
 * @see     http://eonasdan.github.io/bootstrap-datetimepicker/ for more options
 *
 * @package sonrac\tabularWidgets
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class DateRangePickerTabular extends BaseWidget implements ITabularWidget
{
    /**
     * @inheritdoc
     */
    public $assetsBundles = 'sonrac\tabularWidgets\assets\DateTimeRangePickerAssets';

    /**
     * @inheritdoc
     */
    public function getInitScript(): string
    {
        return (new JsExpression("$('#' + id).daterangepicker(options);"));
    }
}