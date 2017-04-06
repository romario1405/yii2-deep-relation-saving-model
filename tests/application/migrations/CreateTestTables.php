<?php

/**
 * Created by PhpStorm.
 * User: Donii Sergii
 * Date: 3/30/17
 * Time: 2:28 PM
 */

namespace sonrac\relations\tests\application\migrations;


use yii\db\Migration;

class CreateTestTables extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->safeDown();
        $tableNames = $this->db->schema->tableNames;
        if (!in_array('article', $tableNames)) {
            $this->createTable('article', [
                'id'         => $this->primaryKey()->comment('ID'),
                'created_at' => $this->integer()->comment('Created At'),
                'updated_at' => $this->integer()->comment('Updated At'),
                'created_by' => $this->integer()->comment('Created By'),
                'updated_by' => $this->integer()->comment('Updated By'),
            ]);

            $this->createTable('article_translate', [
                'id'         => $this->primaryKey(),
                'article_id' => $this->integer()->comment('Article'),
                'title'      => $this->string(255)->comment('Title'),
                'body'       => $this->text()->comment('Body'),
                'slug'       => $this->string(1500)->comment('Slug'),
                'language'   => $this->string(50)->comment('Language'),
                'created_at' => $this->integer()->comment('Created At'),
                'updated_at' => $this->integer()->comment('Updated At'),
                'created_by' => $this->integer()->comment('Created By'),
                'updated_by' => $this->integer()->comment('Updated By'),
            ]);

            $this->createTable('article_attachments', [
                'id'         => $this->primaryKey()->comment('ID'),
                'url'        => $this->string(1000)->comment('Url'),
                'path'       => $this->string(1000)->comment('Path'),
                'type'       => $this->string(1000)->comment('Type'),
                'article_id' => $this->integer()->comment('Article'),
                'created_at' => $this->integer()->comment('Created At'),
                'updated_at' => $this->integer()->comment('Updated At'),
                'created_by' => $this->integer()->comment('Created By'),
                'updated_by' => $this->integer()->comment('Updated By'),
            ]);

            $this->createTable('article_translate_bottle', [
                'id'                   => $this->primaryKey()->comment('ID'),
                'status'               => $this->integer()->comment('Status'),
                'article_translate_id' => $this->integer()->comment('Article Translate'),
                'created_at'           => $this->integer()->comment('Created At'),
                'updated_at'           => $this->integer()->comment('Updated At'),
                'created_by'           => $this->integer()->comment('Created By'),
                'updated_by'           => $this->integer()->comment('Updated By'),
            ]);

            $this->createTable('article_translate_bottle_translate', [
                'id'                          => $this->primaryKey()->comment('ID'),
                'title'                       => $this->string(200)->comment('Title'),
                'body'                        => $this->text()->comment('Body'),
                'description'                 => $this->text()->comment('Description'),
                'language'                    => $this->string(50)->comment('Language'),
                'published_at'                => $this->integer()->comment('Published At'),
                'article_translate_bottle_id' => $this->integer()->comment('Article Translate Bottle'),
                'created_at'                  => $this->integer()->comment('Created At'),
                'updated_at'                  => $this->integer()->comment('Updated At'),
                'created_by'                  => $this->integer()->comment('Created By'),
                'updated_by'                  => $this->integer()->comment('Updated By'),
            ]);

            $this->createTable('tag', [
                'id'         => $this->primaryKey()->comment('ID'),
                'created_at' => $this->integer()->comment('Created At'),
                'updated_at' => $this->integer()->comment('Updated At'),
                'created_by' => $this->integer()->comment('Created By'),
                'updated_by' => $this->integer()->comment('Updated By'),
            ]);

            $this->createTable('tag_translate', [
                'id'          => $this->primaryKey()->comment('ID'),
                'tag_id'      => $this->integer()->comment('Tag'),
                'title'       => $this->string(500)->comment('Title'),
                'description' => $this->string(1000)->comment('Description'),
                'slug'        => $this->string(1000)->comment('Slug'),
                'language'    => $this->string(50)->comment('Language'),
                'created_at'  => $this->integer()->comment('Created At'),
                'updated_at'  => $this->integer()->comment('Updated At'),
                'created_by'  => $this->integer()->comment('Created By'),
                'updated_by'  => $this->integer()->comment('Updated By'),
            ]);

            $this->addForeignKey('fk_tag_translate', 'tag_translate', 'tag_id', 'tag', 'id');

            $this->createTable('article_tag', [
                'id'         => $this->integer()->comment('ID'),
                'article_id' => $this->integer()->comment('Article'),
                'tag_id'     => $this->integer()->comment('Tag'),
                'created_at' => $this->integer()->comment('Created At'),
                'updated_at' => $this->integer()->comment('Updated At'),
                'created_by' => $this->integer()->comment('Created By'),
                'updated_by' => $this->integer()->comment('Updated By'),
            ]);

            $this->addPrimaryKey('pk_article_tag', 'article_tag', ['tag_id', 'article_id']);
            // creates index for column `article_id`
            $this->createIndex('idx-article_tag-article_id', 'article_tag', 'article_id');
            // add foreign key for table `article`
            $this->addForeignKey('fk-article_tag-article_id', 'article_tag', 'article_id', 'article', 'id', 'CASCADE');
            // creates index for column `tag_id`
            $this->createIndex('idx-article_tag-tag_id', 'article_tag', 'tag_id');
            // add foreign key for table `tag`
            $this->addForeignKey('fk-article_tag-tag_id', 'article_tag', 'tag_id', 'tag', 'id', 'CASCADE');
            $this->addForeignKey('fk_article_translate', 'article_translate', 'article_id', 'article', 'id');
            $this->addForeignKey('fk_article_attachments', 'article_attachments', 'article_id', 'article', 'id');
            $this->addForeignKey('article_attachments_a_id', 'article_attachments', 'article_id', 'article', 'id');
            $this->addForeignKey('article_translate_bottle_at_id', 'article_translate_bottle', 'article_translate_id', 'article_translate', 'id');
            $this->addForeignKey('article_translate_bottle_att_id', 'article_translate_bottle_translate', 'article_translate_bottle_id', 'article_translate_bottle', 'id');
            $this->seedData();
        }
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $tableNames = $this->db->schema->tableNames;

        if (in_array('article', $tableNames)) {
            $this->dropForeignKey('fk_tag_translate', 'tag_translate');
            // drops foreign key for table `article`
            $this->dropForeignKey('fk-article_tag-article_id', 'article_tag');
            // drops index for column `article_id`
            $this->dropIndex('idx-article_tag-article_id', 'article_tag');
            // drops foreign key for table `tag`
            $this->dropForeignKey('fk-article_tag-tag_id', 'article_tag');
            // drops index for column `tag_id`
            $this->dropIndex('idx-article_tag-tag_id', 'article_tag');
            $this->dropForeignKey('article_attachments_a_id', 'article_attachments');
            $this->dropForeignKey('fk_article_translate', 'article_translate');
            $this->dropForeignKey('article_translate_bottle_at_id', 'article_translate_bottle');
            $this->dropForeignKey('article_translate_bottle_att_id', 'article_translate_bottle_translate');
            $this->dropTable('tag');
            $this->dropTable('tag_translate');
            $this->dropTable('article_tag');
            $this->dropTable('article_attachments');
            $this->dropTable('article_translate_bottle');
            $this->dropTable('article_translate_bottle_translate');
            $this->dropTable('article_translate');
            $this->dropTable('article');
        }
    }

    protected function seedData()
    {
//        $this->batchInsert('article_attachments', ['id', 'url', 'path', 'type', 'article_id'], [
//            [1, 'test/img', '1.png', 'image/png', 1],
//            [2, 'test/img', '2.jpg', 'image/jpg', 1],
//            [3, 'test/img', '3.gif', 'image/gif', 1],
//            [4, 'test/img', '1.tiff', 'image/tiff', 2],
//            [5, 'test/img', '2.jpeg', 'image/jpeg', 2],
//            [6, 'test/img', '3.ico', 'image/ico', 2],
//        ]);
    }
}