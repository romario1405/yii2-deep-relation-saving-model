<?php
/**
 * Created by PhpStorm.
 * User: Donii Sergii
 * Date: 4/5/17
 * Time: 2:32 PM
 */

namespace sonrac\relations\tests\application\models;

use yii\db\ActiveRecord;

/**
 * Class ArticleTags
 * Article tags model
 *
 * @property int         id
 * @property int         $article_id
 * @property int         $tag_id
 * @property int         $created_at
 * @property int         $updated_at
 * @property int         $created_by
 * @property int         $updated_by
 *
 * @property Article     $article
 * @property ArticleTags $tag
 *
 * @package sonrac\relations\tests\application\models
 */
class ArticleTags extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['article_id', 'required', 'on' => 'update'],
            ['tag_id', 'required'],
            ['tag_id', 'exist', 'targetClass' => Tags::class, 'targetAttribute' => 'id'],
            ['article_id', 'exist', 'targetClass' => Article::class, 'targetAttribute' => 'id', 'on' => 'update'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
        ];
    }

    /**
     * Get article
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::class, ['article_id' => 'id']);
    }

    /**
     * Get tag
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tags::class, ['id' => 'tag_id']);
    }
}