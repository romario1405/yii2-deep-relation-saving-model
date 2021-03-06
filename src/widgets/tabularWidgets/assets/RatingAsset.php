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
class RatingAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/jquery-bar-rating/dist';

    /**
     * @inheritdoc
     */
    public $js = [
        'jquery.barrating.min.js',
    ];

    /**
     * @inheritdoc
     */
    public $css = [
    ];

    /**
     * CSS theme
     *
     * @var string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $theme = 'fontawesome-stars';

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset',
    ];

    /**
     * @inheritdoc
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function init()
    {
        parent::init();

        $cssFile = "themes/{$this->theme}.css";
        if ($this->theme && is_file(Yii::getAlias($this->sourcePath . '/' . $cssFile))) {
            $this->css[] = $cssFile;
        }
    }
}