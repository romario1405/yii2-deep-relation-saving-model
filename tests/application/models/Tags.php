<?php
/**
 * Created by PhpStorm.
 * User: Donii Sergii
 * Date: 4/5/17
 * Time: 2:01 PM
 */

namespace sonrac\relations\tests\application\models;

use yii\db\ActiveRecord;

/**
 * Class Tags
 * Tags model
 *
 * @property int             $id
 * @property int             $created_at
 * @property int             $updated_at
 * @property int             $created_by
 * @property int             $updated_by
 *
 * @property ArticleTags[]   $articleTags
 * @property TagsTranslate[] $tagsTranslate
 *
 * @package sonrac\relations\tests\application\models
 */
class Tags extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
        ];
    }

    /**
     * Get article for tags
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTags()
    {
        return $this->hasMany(ArticleTags::class, ['tag_id' => 'id']);
    }

    /**
     * Get tags translate
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTagsTranslate()
    {
        return $this->hasMany(TagsTranslate::class, ['tag_id' => 'id']);
    }
}