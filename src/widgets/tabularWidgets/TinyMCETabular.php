<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\tabularWidgets;

use yii\web\JsExpression;

/**
 * Class TinyMCETabular
 *
 * @package sonrac\tabularWidgets
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class TinyMCETabular extends BaseWidget implements ITabularWidget
{
    public $assetsBundles = 'sonrac\tabularWidgets\assets\TinyMCEAsset';

    public function getInitScript(): string
    {
        return (new JsExpression("options.selector = '#' + id;\ntinymce.init(options);"));
    }

}