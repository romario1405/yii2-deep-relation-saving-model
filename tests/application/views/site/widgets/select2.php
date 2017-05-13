<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 *
 * @var $form   ActiveForm
 * @var $model  \sonrac\relations\tests\application\models\WidgetModel
 */

use sonrac\tabularWidgets\Select2Tabular;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin();

echo $form->field($model, 'test')->widget(Select2Tabular::class, [
    'form'               => $form,
    'data'               => [
        1 => 1,
        2 => 2,
    ],
    'autoRegisterAssets' => true,
    'pluginOptions'      => [
        'placeholder' => 'Select item...',
        'allowClear'  => 'true',
    ],
    'inputOptions'       => [
        'prompt' => 'Select item...',
    ],
]);

ActiveForm::end();