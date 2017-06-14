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
    /**
     * @inheritdoc
     */
    public $assetsBundles = 'sonrac\tabularWidgets\assets\DateTimePickerAssets';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->setNotExistsOption('options', [], 'fieldOptions');

        if (!isset($this->fieldOptions['options']['style'])) {
            $this->fieldOptions['options']['style'] = '';
        }

        $this->fieldOptions['options']['style'] .= (empty($this->fieldOptions['options']['style']) ? '' : ';') . 'position:relative';
    }

    /**
     * @inheritdoc
     */
    public function getInitScript(): string
    {
        $this->setNotExistsOption('format', 'YYYY-MM-DD');

        return (new JsExpression("$('#' + id).datetimepicker(options);"));
    }
}