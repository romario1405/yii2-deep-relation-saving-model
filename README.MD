# Install 

Run 

```php
composer require sonrac/yii2-relation-trait
```

or add to your `composer.json` in section `require`

```
{
  ...
  "require": {
    ...
    "sonrac/yii2-relation-trait": "^1.0"
    ...
  }
  ...
}
```

## Include to your ActiveRecord model

Add to you ActiveRecord model trate usage: 

```php
namespace app\models;

class Example extends \yii\db\ActiveRecord {
    use \sonrac\relations\TRelation;
}
```

## Load all from post data

```php
$model = new Model();

if ($model->loadAll(\Yii::$app->request->post()) {
}
```

## Save all related records

Not related model will be deleted during save

```php
$model = new Model();

if ($model->loadAll(\Yii::$app->request->post()) {
    if ($model->saveAll()) {
        // Saved successfully
    }
}
```

## Delete all with related records

```php
if ($model->rDeleteAll()) {
    // Deleted successfully
}
```

## Check relation exists with check skip relations

```php

if ($model->checkRelationExist('relationName')) {
    // Relation exists
}

```

## Load relation into model from array data

```php
$model->loadRelation('relationName', $arrayData);
```

If you are want loading relation into model without TRelation usage call with context

```php
$model->loadRelation('relationName', $arrayData, $modelLoadedRelation);
```

## Load all model relation

If you want load all relation in model, use 

```php
$model->loadAllModelRelations();
```

For load all relations to another model without trait, giving context into method

```php
$model->loadAllModelRelations($modelLoadedRelation);
```

# Recommends

Validation rules which using in relation attributes, add to scenario 'update' because relations auto fill all attributes correct link during save.

Example :


```php

namespace sonrac\relations\tests\app\models;

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
 * @package sonrac\relations\tests\app\models
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
            [['article_id', 'tag_id'], 'required', 'on' => 'update'], # Using validate only on update scenario
            ['tag_id', 'exist', 'targetClass' => Tags::class, 'targetAttribute' => 'id', 'on' => 'update'], # Using validate only on update
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

```

# Tests


## Test prepare

First install all composer dependencies

```
composer install
```

Configure your database connection:

* Copy `tests/_db.dist.php` to `tests/_db.php`
* Change connection properties

Sqlite does not working by testing. Create database in mysql/maria.db or postgresql

Run from console in project folder for build codeception dependencies

```
codecept build
````

And run tests

```
codecept run
```

During unit test auto-running `\sonrac\relations\tests\app\boot\Boot` before run test application for clear database and re-create table structure.

## Test structure

Functional test are located in `tests/functional` with codeception config `tests/functional.suite.yml`

Acceptance test are located in `tests/acceptance` with codeception config `tests/acceptance.suite.yml`

Unit test are located in `tests` with codeception config `tests/unit.suite.yml`

## Test data

All test passing on next db structure:

![db-structure](tests/images/db-struct.png?raw=true)

Max depth relation save is save passing all data in all models!

Mock max test data: `tests/_data/mock/max-relation-save.php`

# And Bonus: Repeater widget for you relations OR model:

[Repeater docs usages](docs/Repeater.MD)