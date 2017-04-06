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
 * Class ArticleAttachments
 * Article attachments model
 *
 * @property int     $id
 * @property string  $url
 * @property string  $path
 * @property string  $type
 * @property int     $article_id
 * @property int     $created_at
 * @property int     $updated_at
 * @property int     $created_by
 * @property int     $updated_by
 *
 * @property Article $article
 *
 * @package sonrac\relations\tests\application\models
 */
class ArticleAttachments extends ActiveRecord
{

    use TRelation;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_attachments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'path'], 'required'],
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'number', 'integerOnly' => true],
            ['article_id', 'exist', 'targetClass' => Article::class, 'targetAttribute' => 'id'],
            [['url', 'path', 'type'], 'string', 'max' => 1000],
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
}