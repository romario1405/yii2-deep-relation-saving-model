<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\tabularWidgets;

use yii;
use yii\base\Widget;
use yii\web\JsExpression;

/**
 * Class BaseWidget
 *
 * @package sonrac\tabularWidgets
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
abstract class BaseWidget extends Widget implements ITabularWidget
{
    /**
     * Field options
     *
     * @var array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $fieldOptions = [];

    /**
     * Input options
     *
     * @var array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $inputOptions = [];

    /**
     * Set true if you use widget without tabular for render content
     *
     * @var bool
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $autoRegisterAssets = false;

    /**
     * Enable widget label
     *
     * @var bool
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $enableLabel = false;
    /**
     * ActiveForm object
     *
     * @var yii\widgets\ActiveForm
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $form;
    /**
     * Widget assets bundles
     *
     * @var null|string|\yii\web\AssetBundle[]
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $assetsBundles = null;
    /**
     * Options for js plugin
     *
     * @var array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $pluginOptions;
    /**
     * Widget model
     *
     * @var null|\yii\db\ActiveRecord
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $_model;
    /**
     * Model attribute
     *
     * @var null|string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $_attribute = null;
    protected $fieldType = 'textInput';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->registerBundles();
    }

    private function registerBundles()
    {
        if (is_null($this->assetsBundles)) {
            return;
        }

        $this->assetsBundles = is_array($this->assetsBundles) ? $this->assetsBundles : [$this->assetsBundles];

        foreach ($this->assetsBundles as $assetsBundle) {
            Yii::$app->controller->view->registerAssetBundle($assetsBundle);
        }
    }

    /**
     * Run widget
     *
     * @return array|null
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function run()
    {
        $content = $this->renderField();

        if (!$this->enableLabel) {
            $content->label(false);
        }
        $scripts = $this->getClientScripts();

        if ($this->autoRegisterAssets) {
            echo $content;
            $this->view->registerJs($scripts['script']);
            $script = "{$scripts['functionName']}('{$this->id}', " . json_encode($scripts['pluginOptions']) . ")";
            $this->view->registerJs($script);
            return null;
        }

        return [
            'field' => $content,
            'js'    => $scripts,
        ];
    }

    /**
     * Render widget field
     *
     * @return mixed
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected function renderField()
    {
        return $this->form->field($this->model, $this->_attribute, $this->fieldOptions)->{$this->fieldType}(array_merge($this->inputOptions, [
            'id' => $this->id,
        ]));
    }

    /**
     * @inheritDoc
     */
    public function getClientScripts(): array
    {
        $funcName = $this->getFunctionName();
        return [
            'script'        => new JsExpression('function ' . $funcName . '(id, options, additionalOptions) {
            ' .
                $this->getInitScript() . '
            }'),
            'pluginOptions' => $this->pluginOptions,
            'functionName'  => $funcName,
        ];
    }

    /**
     * Get js function name
     *
     * @return string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected function getFunctionName(): string
    {
        return yii\helpers\StringHelper::basename(get_called_class()) . '_' . time();
    }

    abstract public function getInitScript(): string;

    /**
     * @inheritdoc
     */
    public function getAttribute(): string
    {
        return $this->_attribute ?? '';
    }

    /**
     * @inheritdoc
     */
    public function setAttribute(string $attribute)
    {
        $this->_attribute = $attribute;
    }

    /**
     * @inheritDoc
     */
    public function getModel(): \yii\db\ActiveRecord
    {
        return $this->_model;
    }

    /**
     * @inheritDoc
     */
    public function setModel(\yii\db\ActiveRecord $model)
    {
        $this->_model = $model;
    }
}