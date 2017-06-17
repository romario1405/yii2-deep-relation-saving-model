<?php

use yii\helpers\Url;

class DaterangeWidgetCest
{
    protected $selector = 'input[name="WidgetModel[text]"]';

    protected $dateRangePickerClass = '.daterangepicker';

    protected $startFieldClass = 'daterangepicker_start';

    protected $endFieldClass = 'daterangepicker_end';

    public function _before(AcceptanceTester $i)
    {
        $i->amOnPage(Url::to(['/site/daterange']));
        sleep(1);
    }

    public function dateRangeTest(AcceptanceTester $i)
    {
        $i->seeElement($this->selector);
        $this->callPicker($i);
        $this->cancel($i);
        $this->callPicker($i);

        $i->fillField($this->startFieldClass, '05/14/2017');
        sleep(1);
        $i->fillField($this->endFieldClass, '06/14/2017');
        sleep(1);

        $i->click('.applyBtn');
        $i->click($this->selector);

        $i->seeInField($this->startFieldClass, '05/14/2017');
        sleep(1);
        $i->seeInField($this->endFieldClass, '06/14/2017');
        sleep(1);

        $this->selectDateRange($i);

        $i->click('.applyBtn');
        $i->seeInField($this->selector, '05/15/2017 - 06/30/2017');
    }

    protected function callPicker(AcceptanceTester $i)
    {
        $i->click($this->selector);
        sleep(1);
        $i->seeElement($this->dateRangePickerClass);
        sleep(1);
    }

    protected function cancel(AcceptanceTester $i)
    {
        $i->click('.cancelBtn');
        $i->dontSeeElement($this->dateRangePickerClass);
    }

    protected function selectDateRange(AcceptanceTester $i)
    {
        $i->click('.calendar.left td[data-title=r2c1]');
        sleep(1);
        $i->click('.calendar.right td[data-title=r4c5]');
        sleep(1);
    }
}
