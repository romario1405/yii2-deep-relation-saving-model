<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 *
 * @var $form   ActiveForm
 * @var $model  \sonrac\relations\tests\application\models\WidgetModel
 * @var $model1 \sonrac\relations\tests\application\models\WidgetModel
 * @var $model2 \sonrac\relations\tests\application\models\WidgetModel
 * @var $model3 \sonrac\relations\tests\application\models\WidgetModel
 */

use sonrac\tabularWidgets\ColorInputTabular;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin();

echo $form->field($model, 'text')->widget(ColorInputTabular::class, [
    'form'               => $form,
    'autoRegisterAssets' => true,
]);

ActiveForm::end();