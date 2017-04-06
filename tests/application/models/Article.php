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

use sonrac\relations\TRelation;
use yii\db\ActiveRecord;

/**
 * Class Article
 * Article model
 *
 * @property int                  $id
 * @property int                  $created_at
 * @property int                  $updated_at
 * @property int                  $created_by
 * @property int                  $updated_by
 *
 * @property ArticleTags[]        $articleTags
 * @property ArticleAttachments[] $articleAttachments
 * @property ArticleTranslates[]  $articleTranslates
 *
 * @package sonrac\relations\tests\application\models
 */
class Article extends ActiveRecord
{

    use TRelation;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'number', 'integerOnly' => true],
        ];
    }

    /**
     * Get article tags
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTags()
    {
        return $this->hasMany(ArticleTags::class, ['article_id' => 'id']);
    }

    /**
     * Get article attachments
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleAttachments()
    {
        return $this->hasMany(ArticleAttachments::class, ['article_id' => 'id']);
    }

    /**
     * Get article translates
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTranslates()
    {
        return $this->hasMany(ArticleTranslates::class, ['article_id' => 'id']);
    }
}