<?php
/**
 * Created by PhpStorm.
 * User: Donii Sergii
 * Date: 4/25/17
 * Time: 5:02 PM
 */

/**
 * @var \sonrac\relations\tests\application\models\Article            $model
 * @var \yii\widgets\ActiveForm                                       $form
 * @var sonrac\relations\tests\application\models\ArticleTranslates[] $translates
 * @var \sonrac\relations\tests\application\models\Tags               $tags
 * @var \sonrac\relations\tests\application\models\ArticleAttachments $attachments
 */
use yii\bootstrap\ActiveForm;
use sonrac\relations\tests\application\models\ArticleTranslates;
use sonrac\relations\tests\application\models\ArticleAttachments;
use sonrac\relations\tests\application\models\ArticleTags;
use unclead\multipleinput\TabularInput;

$translates  = count($model->articleTranslates) ? $model->articleTranslates : [new ArticleTranslates()];
$attachments = $model->articleAttachments ?? [new ArticleAttachments()];
$tags        = $model->articleTags ?? [new ArticleTags()];


$form = ActiveForm::begin();

echo TabularInput::widget([
    'models' => $translates
]);

foreach ($translates as $index => $translate) {
    echo $form->field($translate, "title", [
        'inputOptions' => ['name' => "[$index][title]"]
    ]);
}

ActiveForm::end();