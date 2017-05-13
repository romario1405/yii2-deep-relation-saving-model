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
use sonrac\relations\widgets\TabularRelation;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([]);

echo $form->field($model, 'articleTranslates')->widget(TabularRelation::class, [
    'columns'             => [
        [
            'attribute'      => 'title',
            'wrapperOptions' => [
                'options' => [
                    'class' => 'col-md-2',
                ],
            ],
        ],
        [
            'attribute'      => 'article_id',
            'label'          => false,
            'wrapperOptions' => [
                'options' => [
                    'class' => 'hide left',
                ],
            ],
        ],
        [
            'attribute'      => 'slug',
            'wrapperOptions' => [
                'options' => [
                    'class' => 'col-md-2',
                ],
            ],
        ],
        [
            'attribute'      => 'body',
            'wrapperOptions' => [
                'options' => [
                    'class' => 'col-md-2',
                ],
            ],
        ],
        [
            'attribute'      => 'language',
            'wrapperOptions' => [
                'options' => [
                    'class' => 'col-md-2',
                ],
            ],
        ],
    ],
    'headerTemplate'      => '<div class=\'col-md-2\'>{label}</div>',
    'repeaterItemOptions' => [
        'class' => 'repeater-item',
    ],
    'form'                => $form,
    'min'                 => 2,
]);

$form->end();