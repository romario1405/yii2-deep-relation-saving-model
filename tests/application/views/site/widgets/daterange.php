<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 *
 * @var $form   ActiveForm
 * @var $model  \sonrac\relations\tests\application\models\WidgetModel
 */

use sonrac\tabularWidgets\DateRangePickerTabular;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin();

echo $form->field($model, 'text')->widget(DateRangePickerTabular::class, [
    'form'               => $form,
    'autoRegisterAssets' => true,
]);

ActiveForm::end();