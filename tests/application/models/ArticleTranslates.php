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
 * Class ArticleTranslate
 * Article translate model
 *
 * @property int                      $id
 * @property int                      $article_id
 * @property string                   $body
 * @property string                   $title
 * @property string                   $slug
 * @property string                   $language
 * @property int                      $created_at
 * @property int                      $updated_at
 * @property int                      $created_by
 * @property int                      $updated_by
 *
 * @property Article                  $article
 * @property ArticleTranslateBottle   $articleTranslateBottles
 *
 * @package sonrac\relations\tests\application\models
 */
class ArticleTranslates extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_translate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'body', 'slug', 'language'], 'required'],
            ['article_id', 'required', 'on' => 'update'],
            ['article_id', 'number', 'integerOnly' => true],
            ['title', 'string', 'max' => 255],
            ['body', 'string'],
            ['slug', 'string', 'max' => 1500],
            ['article_id', 'exist', 'targetClass' => '\sonrac\relations\tests\application\models\ArticleTranslates', 'targetAttribute' => 'id', 'on' => 'update'],
            ['language', 'string', 'max' => 50],
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'number', 'integerOnly' => true],
        ];
    }

    /**
     * Get article
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::class, ['id' => 'article_id']);
    }

    /**
     * Get article translate bottles
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTranslateBottles()
    {
        return $this->hasMany(ArticleTranslateBottle::class, ['article_translate_id' => 'id']);
    }
}