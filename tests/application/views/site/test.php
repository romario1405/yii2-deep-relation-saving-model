<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */
use bajadev\ckeditor\CKEditor;

$form = \yii\widgets\ActiveForm::begin();

echo CKEditor::widget([
    'name' => 'model',
    'editorOptions' => [
        'preset'               => 'full, basic, standard, full',
        'inline'               => false,
        'filebrowserBrowseUrl' => 'browse-images',
        'filebrowserUploadUrl' => 'upload-images',
        'extraPlugins'         => 'imageuploader',
    ],
]);

\yii\widgets\ActiveForm::end();