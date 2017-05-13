<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 *
 * @var $form   ActiveForm
 * @var $model  \sonrac\relations\tests\application\models\WidgetModel
 */

use sonrac\tabularWidgets\DatePickerTabular;
use sonrac\tabularWidgets\DateTimePickerTabular;
use sonrac\tabularWidgets\TimePickerInputTabular;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin();

echo $form->field($model, 'test')->widget(DatePickerTabular::class, [
    'form'               => $form,
    'autoRegisterAssets' => true,
]);

echo $form->field($model, 'text')->widget(DateTimePickerTabular::class, [
    'form'               => $form,
    'autoRegisterAssets' => true,
]);

echo $form->field($model, 'textNext')->widget(TimePickerInputTabular::class, [
    'form'               => $form,
    'autoRegisterAssets' => true,
]);

ActiveForm::end();