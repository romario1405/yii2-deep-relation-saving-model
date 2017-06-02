<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\tabularWidgets;

use yii\web\JsExpression;

/**
 * Class Select2Tabular
 *
 * @see     http://antenna.io/demo/jquery-bar-rating for more info
 *
 * @package sonrac\tabularWidgets
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class RatingInputTabular extends BaseWidget implements ITabularWidget
{
    /**
     * Rating widget theme
     *
     * @var string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $theme;

    /**
     * Asset bundles rating widget
     *
     * @var string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $assetsBundles = 'sonrac\tabularWidgets\assets\RatingAsset';

    /**
     * Rating values
     *
     * @var array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $data = [];

    /**
     * Max rating value
     *
     * @var int
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $max = 10;

    /**
     * Step
     *
     * @var int
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $step = 1;

    /**
     * Min value
     *
     * @var int
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $min = 1;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!$this->theme) {
            $this->theme = isset($this->pluginOptions['theme']) ? $this->pluginOptions['theme'] : 'fontawesome-stars';
            $this->assetOptions['theme'] = $this->theme;
        }

        $this->setNotExistsOption('theme', $this->theme);

        if (!count($this->data)) {
            for ($i = $this->min; $i <= $this->max; $i += $this->step) {
                $this->data[$i] = $i;
            }
        }

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function getInitScript(): string
    {
        return (new JsExpression("$('#' + id).barrating(options);"));
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