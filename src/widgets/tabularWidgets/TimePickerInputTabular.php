<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\tabularWidgets;

/**
 * Class TimePickerInputTabular
 *
 * @package sonrac\tabularWidgets
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class TimePickerInputTabular extends DatePickerTabular implements ITabularWidget
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->setNotExistsOption('format', 'LT');
    }

}