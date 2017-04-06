<?php

namespace sonrac\relations\tests\unit;

use Codeception\Test\Unit;
use PHPUnit\Framework\TestCase;
use sonrac\relations\tests\application\models\Article;
use sonrac\relations\tests\application\models\ArticleTranslateBottle;
use sonrac\relations\tests\application\models\ArticleTranslates;
use sonrac\relations\tests\application\models\TagsRelation;
use sonrac\relations\tests\application\models\TagsTranslate;
use yii;

/**
 * Class RelationInitTest
 * Relation trait test
 *
 */
class RelationInitAndLoadTest extends Unit
{
    protected $methodLoad = 'loadRelation';

    /**
     * Test load parent model attributes
     */
    public function testSimpleLoad()
    {
        /** @var $this TestCase */
        /** @var \PHPUnit_Framework_MockObject_MockObject $article */
        $article = $this->getMockBuilder(Article::class)->getMock();

        $articleData = [
            'created_at' => time(),
            'updated_at' => time(),
            'created_by' => 1,
            'updated_by' => 1,
        ];

        $article->method('loadAll')
                ->willReturn(true);

        $etalon = array_merge(['id' => null], $articleData);

        $article->method('getAttributes')
                ->willReturn($etalon);
    }

    /**
     * Test check relation exists in model
     */
    public function testCheckRelation()
    {
        $article = new Article();
        $this->assertInstanceOf(\yii\db\ActiveQuery::class, $article->checkRelationExist('ArticleTranslates'));
        $this->assertInstanceOf(\yii\db\ActiveQuery::class, $article->checkRelationExist('articleTranslates'));
        $article->skipRelations = ['articleTags'];
        $this->assertFalse($article->checkRelationExist('articleTags'));
        $this->assertFalse($article->checkRelationExist('ArticleTags'));
        $this->assertFalse($article->checkRelationExist('translates'));
        $article->skipRelations = [];
        $article->skipMethods[] = 'getArticleTags';
        $this->assertFalse($article->checkRelationExist('articleTags'));
        $this->assertFalse($article->checkRelationExist('ArticleTags'));
    }

    /**
     * Test load relation
     *
     */
    public function testLoadRelation()
    {
        $article = new Article();

        if ($this->methodLoad === 'loadAll') {
            $article->loadAll(['tagTranslate' => []]);
        } else {
            $this->assertFalse($article->loadRelation('articleTranslates', []));
        }

        $data = [
            'article_id' => 1,
            'title'      => 'test title',
            'body'       => 'test body',
        ];

        if ($this->methodLoad === 'loadAll') {
            $this->assertTrue($article->loadAll(['articleTranslates' => $data]));
        } else {
            $this->assertFalse($article->loadRelation('articleTranslates', []));
            $this->assertTrue($article->loadRelation('articleTranslates', $data));
        }

        $this->assertInstanceOf(ArticleTranslates::class, current($article->articleTranslates));
        $this->assertEquals(array_merge(['id' => null], $data, [
            'slug'       => null,
            'language'   => null,
            'created_at' => null,
            'updated_at' => null,
            'created_by' => null,
            'updated_by' => null,
        ]), current($article->articleTranslates)->attributes);
    }

    /**
     * Test loading relation with change load context
     *
     */
    public function testLoadRelationWithContext()
    {
        $article = new Article();
        $data    = ['slug' => 'test'];
        if ($this->methodLoad === 'loadAll') {
            $article->loadAll(['articleTranslates' => $data]);
        } else {
            $article->loadRelation('articleTranslates', $data);
        }
        $this->assertInternalType('array', $article->articleTranslates);
        $this->assertInstanceOf(ArticleTranslates::class, current($article->articleTranslates));
        $translate = current($article->articleTranslates);
        $article->loadRelation('articleTranslateBottles', ['created_at' => 123], $translate);

        $this->assertInstanceOf(ArticleTranslateBottle::class, current($translate->articleTranslateBottles));
        $this->assertEquals([
                                'id'                   => null,
                                'created_at'           => 123,
                                'updated_at'           => null,
                                'created_by'           => null,
                                'updated_by'           => null,
                                'status'               => null,
                                'article_translate_id' => null,
                            ], current($translate->articleTranslateBottles)->attributes);
    }

    /**
     * Insert tags into database
     */
    protected function insertTags()
    {
        Yii::$app->db->createCommand()
                     ->batchInsert('tag', ['id'], [[1], [2]])->execute();
        Yii::$app->db->createCommand()->batchInsert('tag_translate', ['id', 'title', 'description', 'slug', 'tag_id', 'language'], [
            [1, 'Tag1', 'Tag1 description', 'tag1', 1, 'ru-RU'],
            [2, 'Tag2', 'Tag2 description', 'tag2', 1, 'en-US'],
            [3, 'Tag3', 'Tag3 description', 'tag3', 1, 'uk-UA'],
            [4, 'Tag4', 'Tag4 description', 'tag4', 2, 'ru-RU'],
            [5, 'Tag5', 'Tag5 description', 'tag5', 2, 'en-US'],
            [6, 'Tag6', 'Tag6 description', 'tag6', 2, 'uk-UA'],
        ])->execute();
    }

    /**
     * Test load exist relation
     */
    public function testLoadExistsRelation()
    {
        $this->insertTags();

        $tags = TagsRelation::findOne(['id' => 1]);
        $this->assertInternalType('array', $tags->tagsTranslate);
        $this->assertCount(3, $tags->tagsTranslate);
        $tags = TagsRelation::findOne(['id' => 1]);

        $data = [
            'id'     => 1,
            'title'  => 'change Tag1 title',
            'tag_id' => 1,
        ];
        if ($this->methodLoad === 'loadAll') {
            $tags->loadAll(['tagsTranslate' => $data]);
        } else {
            $tags->loadRelation('tagsTranslate', $data);
        }

        $this->assertInternalType('array', $tags->tagsTranslate);
        $this->assertCount(1, $tags->tagsTranslate);
        $this->assertInstanceOf(TagsTranslate::class, current($tags->tagsTranslate));
        $this->assertFalse(current($tags->tagsTranslate)->isNewRecord);
        $this->assertEquals([
                                'id'          => 1,
                                'tag_id'      => 1,
                                'title'       => 'change Tag1 title',
                                'description' => 'Tag1 description',
                                'slug'        => 'tag1',
                                'language'    => 'ru-RU',
                                'created_at'  => null,
                                'updated_at'  => null,
                                'created_by'  => null,
                                'updated_by'  => null,
                            ], current($tags->tagsTranslate)->attributes);
    }

    /**
     * Test load all to relation
     */
    public function testLoadAllRelations()
    {
        $this->methodLoad = 'loadAll';
        $this->testLoadExistsRelation();
        $this->testLoadRelation();
        $this->testLoadRelationWithContext();
    }

    /**
     * Test delete all
     */
    public function testDeleteAll()
    {
        $this->insertTags();
        $tags = TagsRelation::findOne(['id' => 1]);
        $this->assertTrue($tags->rDeleteAll());
        $this->assertNull(TagsRelation::findOne(['id' => 1]));
    }

    /**
     * Test save all
     */
    public function testSaveAll()
    {
        $tagsData = [
            'updated_at' => time(),
            'created_at' => time(),
            'created_by' => 1,
            'updated_by' => 1,
        ];

        $translateData = [
            [
                'title'       => 'Tag Insert',
                'description' => 'Tag insert description',
                'slug'        => 'insert slug',
                'language'    => 'uk-UA',
                'created_at'  => time(),
                'updated_at'  => time(),
                'updated_by'  => 2,
                'created_by'  => 2,
            ],
        ];
        $this->tagsCreation($tagsData, $translateData);
        $this->tagsCreation($tagsData, $translateData, true);
    }

    /**
     * Test tags creation
     *
     * @param array $tagsData
     * @param array $translateData
     * @param bool  $one
     * @param int   $id
     */
    protected function tagsCreation($tagsData, $translateData, $one = false, $id = 1)
    {
        $tags = new TagsRelation();

        $data = $one ? [
            'Tags' => array_merge($tagsData, ['TagsTranslate' => $translateData]),
        ] : [
            'Tags'          => $tagsData,
            'TagsTranslate' => $translateData,
        ];

        $tags->loadAll($data);

        $this->assertTrue($tags->validateAll());
        $this->assertTrue($tags->saveAll());
        $data = (new yii\db\Query())
            ->from('tag')
            ->where(['id' => $id])
            ->one();
        $this->assertInternalType('array', $data);
        foreach ($tagsData as $prop => $tag) {
            $this->assertArrayHasKey($prop, $data);
            $this->assertEquals($tag, $data[$prop]);
        }

        $data = (new yii\db\Query())
            ->from('tag_translate')
            ->where(['tag_id' => $id])
            ->all();

        $this->assertInternalType('array', $data);
        $this->assertCount(count($translateData), $data);
        foreach ($translateData as $index => $tagTranslate) {
            foreach ($tagTranslate as $prop => $item) {
                $this->assertArrayHasKey($prop, $data[$index]);
                $this->assertEquals($item, $data[$index][$prop]);
            }
        }
    }

    /**
     * Test save all on max depth
     */
    public function testSaveAllMaxDepth()
    {
        $data = require __DIR__ . '/../../tests/_data/max-relation-depth-save.php';

        $tagsData      = $data['Tags'];
        $translateData = $data['Tags']['tagsTranslate'];

        unset($tagsData['tagsTranslate']);

        $this->tagsCreation($tagsData, $translateData);
        $this->tagsCreation($tagsData, $translateData, true);

        $article = new Article();
        $this->assertTrue($article->loadAll($data['Article']));
        $this->assertTrue($article->validateAll());
        $this->assertTrue($article->saveAll());

        $_data = (new yii\db\Query())
            ->from('article')
            ->all();

        $this->assertCount(1, $_data);
        $_data = (new yii\db\Query())
            ->from('article_translate')
            ->where(['article_id' => 1])
            ->all();

        $this->assertCount(count($data['Article']['ArticleTranslates']), $_data);

        foreach ($data['Article']['ArticleTranslates'] as $index => $translates) {
            foreach ($translates as $prop => $translate) {
                if ($prop !== 'articleTranslateBottles') {
                    $this->assertArrayHasKey($prop, $_data[$index]);
                    $this->assertEquals($translate, $_data[$index][$prop]);
                }
            }

            $bottles = (new yii\db\Query())
                ->from('article_translate_bottle')
                ->where(['article_translate_id' => $_data[$index]['id']])
                ->all();

            $this->assertCount(count($translates['articleTranslateBottles']), $bottles);

            foreach ($translates['articleTranslateBottles'] as $bottleIndex => $articleTranslateBottle) {

                $this->assertEquals($articleTranslateBottle['status'], $bottles[$bottleIndex]['status']);

                $translateBottles = (new yii\db\Query())
                    ->from('article_translate_bottle_translate')
                    ->where(['article_translate_bottle_id' => $bottles[$bottleIndex]['id']])
                    ->all();

                $this->assertCount(count($articleTranslateBottle['articleTranslateBottleTranslates']), $translateBottles);

                foreach ($translateBottles as $indexTrBottle => $translateBottle) {
                    foreach ($translateBottle as $bottlePropTr => $bottleTrValue) {
                        if (isset($articleTranslateBottle['articleTranslateBottleTranslates'][$indexTrBottle][$bottlePropTr])) {
                            $this->assertEquals($bottleTrValue, $articleTranslateBottle['articleTranslateBottleTranslates'][$indexTrBottle][$bottlePropTr]);
                        }
                    }
                }
            }
        }

        $_attachments = (new yii\db\Query())
            ->from('article_attachments')
            ->where(['article_id' => 1])
            ->all();

        $attachments = $data['Article']['ArticleAttachments'];
        $this->assertCount(count($attachments), $_attachments);
        foreach ($attachments as $index => $articleAttachment) {
            foreach ($articleAttachment as $prop => $value) {
                $this->assertEquals($_attachments[$index][$prop], $value);
            }
        }

        $_articleTags = (new yii\db\Query())
            ->from('article_tag')
            ->where(['article_id' => 1])
            ->all();

        $articleTags = $data['Article']['ArticleTags'];
        $this->assertCount(count($articleTags), $_articleTags);
        foreach ($articleTags as $index => $articleTag) {
            foreach ($articleTag as $prop => $value) {
                $this->assertEquals($_articleTags[$index][$prop], $value);
            }
        }

        # Check delete after after save not related data
        $attachments = [
            [
                'url'  => 'new attach',
                'path' => 'new path attach',
                'type' => 'image new attach',
            ],
        ];
        $this->assertTrue($article->loadAll(['ArticleAttachments' => $attachments]));

        $this->assertTrue($article->validateAll());

        $this->assertTrue($article->saveAll());

        $_attachments = (new yii\db\Query())
            ->from('article_attachments')
            ->where(['article_id' => 1])
            ->all();


        $this->assertCount(count($attachments), $_attachments);
        foreach ($attachments as $index => $articleAttachment) {
            foreach ($articleAttachment as $prop => $value) {
                $this->assertEquals($_attachments[$index][$prop], $value);
            }
        }
    }
}