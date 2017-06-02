<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\tabularWidgets\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Class RatingAsset
 *
 * @package sonrac\tabularWidgets\assets
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class RangeInputAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/ion.rangeslider';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/ion.rangeSlider.min.js',
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        'css/ion.rangeSlider.css',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset',
    ];

    /**
     * Skin
     *
     * @var string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $skin = 'Nice';

    public function init()
    {
        parent::init();

        if ($this->skin) {
            $path = "css/ion.rangeSlider.skin" . ucfirst($this->skin) . ".css";

            if (is_file(Yii::getAlias($this->sourcePath . '/' . $path))) {
                $this->css[] = $path;
            }
        }
    }
}