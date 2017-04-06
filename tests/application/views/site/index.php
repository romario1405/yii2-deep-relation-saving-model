<?php
/**
 * Created by PhpStorm.
 * User: Donii Sergii
 * Date: 4/4/17
 * Time: 2:51 PM
 */

use yii\grid\GridView;
use yii\helpers\Html;

echo Html::a('Create', ['/site/create'], ['class' => 'btn btn-success']);

/**
 * @var $model        \sonrac\relations\tests\application\models\search\ArticleSearch
 * @var $dataProvider \yii\data\ActiveDataProvider
 */
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $model,
    'columns'      => [
        'id', 'title', 'body',
    ],
]);