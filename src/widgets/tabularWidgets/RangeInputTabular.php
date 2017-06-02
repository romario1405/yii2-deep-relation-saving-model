<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\tabularWidgets;

use yii\web\JsExpression;

/**
 * Class RangeInputTabular
 *
 * @package sonrac\tabularWidgets
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class RangeInputTabular extends BaseWidget implements ITabularWidget
{
    /**
     * Max rating value
     *
     * @var int
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $max = 10;

    /**
     * Step
     *
     * @var int
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $step = 1;

    /**
     * Min value
     *
     * @var int
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $min = 1;

    /**
     * @inheritdoc
     */
    public $assetsBundles = 'sonrac\tabularWidgets\assets\RangeInputAsset';

    /**
     * Range input skin
     *
     * @var string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $skin = 'Nice';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->assetOptions['skin'] = $this->skin ?: 'Nice';
        parent::init();

        $this->setNotExistsOption('min', 1);
        $this->setNotExistsOption('max', 10);
        $this->setNotExistsOption('step', 1);
    }

    /**
     * @inheritdoc
     */
    public function getInitScript(): string
    {
        return (new JsExpression("$('#' + id).ionRangeSlider(options);"));
    }

}