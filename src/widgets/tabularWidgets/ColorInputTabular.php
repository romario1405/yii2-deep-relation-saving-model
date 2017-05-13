<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\tabularWidgets;

use yii\web\JsExpression;

/**
 * Class ColorInputTabular
 *
 * @package sonrac\tabularWidgets
 *
 * @see     http://www.eyecon.ro/colorpicker for more detail options
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class ColorInputTabular extends BaseWidget implements ITabularWidget
{
    public $assetsBundles = 'sonrac\tabularWidgets\assets\ColorInputAssets';

    /**
     * @inheritdoc
     */
    public function getInitScript(): string
    {
        return (new JsExpression("$('#' + id).ColorPicker(options);"));
    }

}