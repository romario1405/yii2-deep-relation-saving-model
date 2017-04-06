<?php
/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 4/3/17
 * Time: 21:32
 *
 * @author Doniy Serhey <doniysa@gmail.com>
 */

namespace sonrac\relations\tests\application\models;

use yii\db\ActiveRecord;

/**
 * Class ArticleTranslateBottleTranslate
 * Article translate bottle translate model
 *
 * @property int                    $id
 * @property string                 $title
 * @property string                 $description
 * @property int                    $created_at
 * @property int                    $updated_at
 * @property int                    $created_by
 * @property int                    $updated_by
 *
 * @property ArticleTranslateBottle $articleTranslateBottle
 *
 * @package sonrac\relations\tests\application\models
 */
class ArticleTranslateBottleTranslate extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_translate_bottle_translate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'body', 'language'], 'required'],
            ['title', 'string', 'max' => 255],
            ['description', 'string'],
            ['article_translate_bottle_id', 'exist', 'targetClass' => '\sonrac\relations\tests\application\models\ArticleTranslateBottle', 'targetAttribute' => 'id'],
            ['language', 'string', 'max' => 50],
            ['language', 'default', 'value' => \Yii::$app->language],
            [['published_at', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'number', 'integerOnly' => true],
        ];
    }

    /**
     * Get article translate bottle
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTranslateBottle()
    {
        return $this->hasOne(ArticleTranslateBottle::class, ['id' => 'article_translate_bottle_id']);
    }
}