<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\tabularWidgets;


/**
 * Class ITabularWidget
 * Interface for custom tabular widget
 *
 * @property \yii\db\ActiveRecord $model         Widget model
 * @property string               $attribute     Attribute name in model
 * @property array                $widgetOptions Widget options
 * @property array                $pluginOptions JS plugin options
 *
 * @package sonrac\tabularWidgets
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
interface ITabularWidget
{
    /**
     * Get client scripts template for tabular widget
     *
     * @return array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function getClientScripts(): array;

    /**
     * Get model attribute name
     *
     * @return string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function getAttribute(): string;

    /**
     * Set model attribute
     *
     * @param string $attribute
     *
     * @return mixed
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function setAttribute(string $attribute);

    /**
     * Get widget model
     *
     * @return \yii\db\ActiveRecord
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function getModel(): \yii\db\ActiveRecord;

    /**
     * Set widget model
     *
     * @param \yii\db\ActiveRecord $model
     *
     * @return mixed
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function setModel(\yii\db\ActiveRecord $model);

    /**
     * Get init script for tabular widget
     *
     * @return string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function getInitScript(): string;
}