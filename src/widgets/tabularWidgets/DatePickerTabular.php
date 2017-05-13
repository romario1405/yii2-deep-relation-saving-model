<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\tabularWidgets;

use yii\web\JsExpression;

/**
 * Class DatePickerTabular
 *
 * @see     http://eonasdan.github.io/bootstrap-datetimepicker/ for more options info
 *
 * @package sonrac\tabularWidgets
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class DatePickerTabular extends BaseWidget implements ITabularWidget
{
    public $assetsBundles = 'sonrac\tabularWidgets\assets\DateTimePickerAssets';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (!isset($this->fieldOptions['options'])) {
            $this->fieldOptions['options'] = [];
        }

        if (!isset($this->fieldOptions['options']['style'])) {
            $this->fieldOptions['options']['style'] = '';
        }

        $this->fieldOptions['options']['style'] .= ';position:relative';
    }

    /**
     * @inheritdoc
     */
    public function getInitScript(): string
    {
        if (!isset($this->pluginOptions['format'])) {
            $this->pluginOptions['format'] = 'YYYY-mm-DD';
        }

        return (new JsExpression("$('#' + id).datetimepicker(options);"));
    }
}