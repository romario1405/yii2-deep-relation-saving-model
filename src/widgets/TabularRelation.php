<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\relations\widgets;

use sonrac\relations\assets\TabularAssets;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\StringHelper;
use yii\web\JsExpression;
use yii\widgets\ActiveField;
use yii\widgets\ActiveForm;

/**
 * Class TabularRelation
 *
 * @package sonrac\relations\widgets
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class TabularRelation extends Widget
{
    /**
     * ActiveForm instance for render repeater items
     *
     * @var null|ActiveForm
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $form = null;

    /**
     * Model
     *
     * @var ActiveRecord
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $model;

    /**
     * Columns config list
     *
     * @var array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $columns;

    /**
     * Model relation name
     *
     * @var string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $attribute;

    /**
     * Max count models in repeater
     *
     * @var int
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $max = 5;

    /**
     * Minimal count models in repeater
     *
     * @var int
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $min = 1;

    /**
     * Allow empty value
     *
     * @var bool
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $allowEmpty = false;

    /**
     * Repeater view
     *
     * @var string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $viewTemplate = '_repeater';

    /**
     * Header template
     *
     * @var bool
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $headerTemplate = false;

    /**
     * Render labels attributes
     *
     * @var bool
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $renderLabels = false;

    /**
     * Nested repeaters widgets
     *
     * @var TabularRelation[]
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $nestedRepeaters = [];

    /**
     * Repeater options
     *
     * @var array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $pluginOptions = [];

    /**
     * Row wrapper options
     *
     * @var null
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $rowWrapperOptions = null;
    /**
     * Repeater item options
     *
     * @var null|array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $repeaterItemOptions = null;
    /**
     * Repeater title
     *
     * @var string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $repeaterTitle = '';
    /**
     * @var array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $widgetsList = [];
    /**
     * Header title blocks
     *
     * @var array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $headers = [];
    /**
     * Attribute client validators list
     *
     * @var array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $validators = [];
    /**
     * Relation model instance
     *
     * @var null|ActiveRecord
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $_model = null;
    /**
     * Generated plugin options
     *
     * @var array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $_pluginOptions = [];
    protected $_defaultWidgets = [
        'select2' => '',
    ];

    /**
     * @inheritdoc
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function init()
    {
        parent::init();

        $this->widgetsList = array_merge($this->_defaultWidgets, $this->widgetsList ?? []);

        $relMethod = 'get' . ucfirst($this->attribute);

        if (!(($query = $this->model->{$relMethod}()) instanceof ActiveQuery)) {
            throw new InvalidConfigException('Invalid model relation');
        }

        if (!is_array($this->columns) || !count($this->columns)) {
            throw new InvalidConfigException('Columns config empty');
        }

        if (!($model = $this->model->{$this->attribute})) {
            /** @var ActiveQuery $query */
            /** @var array $link */
            $link = $query->link;

            /** @var ActiveRecord $model */
            $model = $this->_model = new $query->modelClass;

            if (!$this->model->isNewRecord) {
                $relAttributes = [];

                foreach ($link as $field => $attribute) {
                    if ($this->model->{$attribute}) {
                        $relAttributes[$field] = $this->model->attributes;
                    }
                }

                $model->setAttributes($relAttributes, false);
            }

            $model = $query->multiple ? [$model, $model] : $model;

            $this->model->populateRelation($this->attribute, $model);
        }

        if (!$query->multiple) {
            $this->min = 1;
            $this->max = 1;
            $this->allowEmpty = false;
        }

        $this->prepareColumnsConfig();

        if (!$this->headerTemplate) {
            $this->headerTemplate = '<div class=\'title-class\'>{label}</div>';
        }
    }

    /**
     * Prepare columns config
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected function prepareColumnsConfig()
    {
        foreach ($this->columns as &$column) {
            if (is_string($column)) {
                $column = [
                    'attribute' => $column,
                ];
            }
            if (!isset($column['attribute'])) {
                throw new InvalidConfigException('Attribute must be defined');
            }

            if (!isset($column['widget'])) {
                $column['widget'] = 'textInput';
            }

            $attribute = $column['attribute'];

            if (!property_exists($this->_model, $attribute) && !$this->_model->hasAttribute($attribute)) {
                throw new InvalidConfigException('Attribute must be exists in model');
            }

            if (!isset($column['wrapperOptions'])) {
                $column['wrapperOptions'] = [];
            }

            if (!isset($column['widgetOptions'])) {
                $column['widgetOptions'] = [];
            }

            if (!isset($column['inputOptions'])) {
                $column['inputOptions'] = [];
            }

            $this->headers[] = isset($column['label']) ? $column['label'] : $this->_model->getAttributeLabel($attribute);

            $validators = $this->_model->getActiveValidators($attribute);

            foreach ($validators as $validator) {
                if (!isset($this->validators[$attribute])) {
                    $this->validators[$attribute] = [];
                }

                $this->validators[] = [
                    'name'     => $attribute,
                    'validate' => (new JsExpression('function (attribute, value, messages, deferred, form) {
                        ' . $validator->clientValidateAttribute($this->_model, $attribute, $this->view) . '                        
                    }')),
                ];
            }
        }
    }

    /**
     * @inheritdoc
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function run()
    {
        TabularAssets::register($this->view);
        return Html::tag('div', $this->renderData(), [
            'id' => $this->id,
        ]);
    }

    /**
     * Render next repeater row
     *
     * @return string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected function renderData()
    {
        $viewContent = $this->render($this->viewTemplate, [
            'widget'       => $this,
            'items'        => $this->renderRows(),
            'headers'      => $this->renderHeader(),
            'title'        => $this->repeaterTitle,
            'repeaterName' => StringHelper::basename($this->model->className()),
        ]);

        $this->registerScripts();

        return str_replace(['{title}', '{items}', '{headers}'], ['title', $this->renderRows(), $this->renderHeader()], $viewContent);
    }

    /**
     * Render repeater rows
     *
     * @return string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected function renderRows()
    {
        $models = $this->model->{$this->attribute};
        $models = is_array($models) ? $models : [$models];

        $content = '';

        foreach ($models as $index => $model) {
            $content .= Html::beginTag('div', ArrayHelper::merge([
                'data-repeater-item' => '',
            ], $this->repeaterItemOptions ?? []));
            foreach ($this->columns as $column) {
                $attribute = $column['attribute'];

                if (!isset($column['inputOptions'])) {
                    $column['inputOptions'] = [];
                }

                if (!isset($column['inputOptions']['data'])) {
                    $column['inputOptions']['data'] = [];
                }

                if (!isset($column['options'])) {
                    $column['options'] = [];
                }

                $column['inputOptions']['data']['data-origin-name'] = $column['attribute'];
                $modelName = StringHelper::basename($this->model->className());
                $currentModelName = lcfirst(StringHelper::basename($model->className()));
                $id = strtolower($modelName) . '-' . strtolower($currentModelName) . "-{$index}-" . $attribute;
                $column['options']['class'] = "field-{$id}";

                $column['inputOptions']['data']['name'] = "{$modelName}[{$currentModelName}][{$index}][$attribute]";
                $column['inputOptions']['data']['id'] = $id;

                $field = $this->form->field($model, $attribute, $column['wrapperOptions']);

                if (!$this->renderLabels) {
                    $field->label(false);
                }

                $content .= $this->resolveColumn($column, $field);
            }
            $content .= Html::button('Delete', [
                'class'                => 'btn btn-danger',
                'data-repeater-delete' => '',
            ]);
            $content .= Html::tag('div', '', ['class' => 'clearfix']);
            $content .= Html::endTag('div');
        }

        return $content;
    }

    /***
     * Render column
     *
     * @param array       $column Column config
     * @param ActiveField $field  Active field object
     *
     * @return string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected function resolveColumn($column, $field)
    {
        $type = isset($column['type']) ? $column['type'] : 'textInput';

        return $type !== 'widget' ? call_user_func_array([$field, $type], $column['inputOptions']) :
            call_user_func_array(['field', 'widget'], $column['widgetOptions']);
    }

    /**
     * Render repeater header
     *
     * @return string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected function renderHeader()
    {
        $content = '';
        foreach ($this->headers as $header) {
            if (empty($header)) {
                continue;
            }
            $content .= str_replace('{label}', $header, $this->headerTemplate);
        }

        return $content;
    }

    protected function registerScripts()
    {
        $this->_pluginOptions = array_merge([
            'selector'         => '#' . $this->form->id,
            'clientValidation' => $this->validators,
            'repeaterName'     => StringHelper::basename($this->model->className()),
            'additionalName'   => lcfirst(StringHelper::basename($this->_model->className())),
        ], ['min' => $this->min ?? 1, 'max' => $this->max], $this->pluginOptions);
        $this->view->registerJs(new JsExpression("
            $('#{$this->id}').tabularWidget(" . Json::encode($this->_pluginOptions) . ");
        "));
    }
}