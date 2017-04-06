<?php
/**
 * Created by PhpStorm.
 * User: Donii Sergii
 * Date: 4/10/17
 * Time: 1:26 PM
 *
 * @author Donii Sergii <doniysa@gmail.com>
 */

return [
    'Tags'    => [
        'tagsTranslate' => [
            [
                'title'       => 'First tag',
                'description' => 'First tag description',
                'slug'        => 'first_tag',
            ],
            [
                'title'       => 'Second tag',
                'description' => 'Second tag description',
                'slug'        => 'second_tag',
            ],
            [
                'title'       => 'Third tag',
                'description' => 'Third tag description',
                'slug'        => 'third_tag',
            ],
        ],
    ],
    'Article' => [
        'ArticleTranslates'  => [
            [
                'title'                   => 'test Title 1',
                'slug'                    => 'Test Slug 1',
                'body'                    => 'Test translate body',
                'language'                => 'en-US',
                'articleTranslateBottles' => [
                    [
                        'status'                           => 1,
                        'articleTranslateBottleTranslates' => [
                            [
                                'title'       => 'Test bottle translate 1 title',
                                'description' => 'Test bottle translate 1 description',
                                'body'        => 'Test bottle translate 1 body',
                                'language'    => 'en-US',
                            ],
                            [
                                'title'       => 'Test bottle translate 2 title',
                                'description' => 'Test bottle translate 2 description',
                                'body'        => 'Test bottle translate 2 body',
                                'language'    => 'ru-RU',
                            ],
                            [
                                'title'       => 'Test bottle translate 3 title',
                                'description' => 'Test bottle translate 3 description',
                                'body'        => 'Test bottle translate 3 body',
                                'language'    => 'uk-UA',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'title'                   => 'test Title 2',
                'slug'                    => 'Test Slug 2',
                'body'                    => 'Test translate body 2',
                'language'                => 'ru-RU',
                'articleTranslateBottles' => [
                    [
                        'status'                           => 1,
                        'articleTranslateBottleTranslates' => [
                            [
                                'title'       => 'Test bottle translate 1 title for article translate 2',
                                'description' => 'Test bottle translate 1 description  for article translate 2',
                                'body'        => 'Test bottle translate 1 body for article translate 2',
                                'language'    => 'ru-RU',
                            ],
                            [
                                'title'       => 'Test bottle translate 2 title  for article translate 2',
                                'description' => 'Test bottle translate 2 description  for article translate 2',
                                'body'        => 'Test bottle translate 2 body for article translate 2',
                                'language'    => 'uk-UA',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'title'                   => 'test Title 3',
                'slug'                    => 'Test Slug 3',
                'body'                    => 'Test translate body 3',
                'language'                => 'uk-UA',
                'articleTranslateBottles' => [
                    [
                        'status'                           => 1,
                        'articleTranslateBottleTranslates' => [
                            [
                                'title'       => 'Test bottle translate 1 title for article translate 3',
                                'description' => 'Test bottle translate 1 description  for article translate 3',
                                'body'        => 'Test bottle translate 1 body for article translate 3',
                                'language'    => 'ru-RU',
                            ],
                            [
                                'title'       => 'Test bottle translate 2 title  for article translate 3',
                                'description' => 'Test bottle translate 2 description  for article translate 3',
                                'body'        => 'Test bottle translate 2 body for article translate 3',
                                'language'    => 'en-US',
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'ArticleAttachments' => [
            [
                'url'  => 'test url 1',
                'path' => 'test path 1',
                'type' => 'image 1',
            ],
            [
                'url'  => 'test url 2 ',
                'path' => 'test path 2',
                'type' => 'image 2',
            ],
            [
                'url'  => 'test url 3',
                'path' => 'test path 3',
                'type' => 'image 3',
            ],
        ],
        'ArticleTags'         => [
            [
                'tag_id' => 1,
            ],
            [
                'tag_id' => 2,
            ],
        ],
    ],
];