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
 * @property int    $id
 * @property string $title
 * @property string $description
 * @property string $slug
 * @property string $language
 * @property int    $created_at
 * @property int    $updated_at
 * @property int    $created_by
 * @property int    $updated_by
 *
 * @property Tags[] $tags
 *
 * @package sonrac\relations\tests\application\models
 */
class TagsTranslate extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag_translate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            ['tag_id', 'exist', 'targetClass' => Tags::class, 'targetAttribute' => 'id', 'on' => 'update'],
            ['tag_id', 'required', 'on' => 'update'],
            [['title'], 'required'],
            ['title', 'string', 'max' => 500],
            ['language', 'string', 'max' => 50],
            ['language', 'default', 'value' => \Yii::$app->language],
            [['description', 'slug'], 'string', 'max' => 500],
        ];
    }

    /**
     * Get tags
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tags::class, ['id' => 'tag_id']);
    }

}