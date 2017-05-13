<?php
/**
 * @var $model \sonrac\relations\tests\application\models\WidgetModel
 *
 * @author Donii Sergii <doniysa@gmail.com>
 */

use sonrac\tabularWidgets\ckEditor\CKEditorTabular;
use yii\widgets\ActiveForm;

$this->title = 'Tabular Ckeditor test widget';

$form = ActiveForm::begin();

echo $form->field($model, 'test')->widget(CKEditorTabular::class, [
    'autoRegisterAssets' => true,
    'form'               => $form,
    'fileUploadAction'   => ['site/ck-upload'],
    'fileBrowserAction'  => ['site/ck-view'],
]);

ActiveForm::end();