<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\relations\tests\application\models;

use yii\db\ActiveRecord;

/**
 * Class WidgetModel
 *
 * @property string $test
 *
 * @package sonrac\relations\tests\application\models
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class WidgetModel extends ActiveRecord {

    /**
     * Test attribute
     *
     * @var string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $test;

    /**
     * Text attribute
     *
     * @var string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $text;

    /**
     * Text attribute
     *
     * @var string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $textNext;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['test', 'required'],
            ['test', 'string'],
        ];
    }
}