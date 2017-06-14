<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\tabularWidgets;

/**
 * Class DateTimePickerTabular
 *
 * @see     http://eonasdan.github.io/bootstrap-datetimepicker/ for more options
 *
 * @package sonrac\tabularWidgets
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class DateTimePickerTabular extends DatePickerTabular implements ITabularWidget
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->setNotExistsOption('format', 'YYYY-MM-DD HH:mm:ss');
    }
}