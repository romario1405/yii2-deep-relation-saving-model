<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\tabularWidgets;

use yii\web\JsExpression;

/**
 * Class Select2Tabular
 *
 * @package sonrac\tabularWidgets
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class Select2Tabular extends BaseWidget implements ITabularWidget
{

    /**
     * Widget data
     *
     * @var array $data
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $data;

    public $assetsBundles = 'sonrac\tabularWidgets\assets\Select2Asset';

    /**
     * @inheritdoc
     */
    public function getInitScript(): string
    {
        return (new JsExpression("$('#' + id).select2(options);"));
    }

    /**
     * @inheritdoc
     */
    protected function renderField()
    {
        return $this->form->field($this->model, $this->_attribute, $this->fieldOptions)->dropDownList($this->data, array_merge($this->inputOptions, [
            'id' => $this->id,
        ]));
    }


}