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
 * Class ArticleTranslateBottle
 *
 * @property int                               $id
 * @property int                               $status
 * @property int                               $article_translate_id
 * @property int                               $created_at
 * @property int                               $updated_at
 * @property int                               $created_by
 * @property int                               $updated_by
 *
 * @property ArticleTranslates                 $articleTranslate
 * @property ArticleTranslateBottleTranslate[] $articleTranslateBottleTranslates
 *
 * @const   STATUS_ACTIVE
 * @const   STATUS_DISABLED
 *
 * @package sonrac\relations\tests\application\models
 */
class ArticleTranslateBottle extends ActiveRecord
{
    /**
     * Active bottle
     *
     * @const
     */
    const STATUS_ACTIVE = 1;

    /**
     * Disable bottle
     */
    const STATUS_DISABLED = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_translate_bottle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_translate_id'], 'required', 'on' => 'update'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['article_translate_id', 'exist', 'targetClass' => 'app\models\ArticleTranslate', 'targetAttribute' => 'id', 'on' => 'update'],
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'number', 'integerOnly' => true],
        ];
    }

    /**
     * Get article translate
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTranslate()
    {
        return $this->hasOne(ArticleTranslates::class, ['id' => 'article_translate_id']);
    }

    /**
     * Get translate for article bottle
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTranslateBottleTranslates()
    {
        return $this->hasMany(ArticleTranslateBottleTranslate::class, ['article_translate_bottle_id' => 'id']);
    }
}