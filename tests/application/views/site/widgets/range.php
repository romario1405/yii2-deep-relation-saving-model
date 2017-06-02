<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 *
 * @var $form   ActiveForm
 * @var $model  \sonrac\relations\tests\application\models\WidgetModel
 */

use sonrac\tabularWidgets\RangeInputTabular;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin();

$model->text = 5;

echo $form->field($model, 'text')->widget(RangeInputTabular::class, [
    'autoRegisterAssets' => true,
    'form'               => $form,
]);