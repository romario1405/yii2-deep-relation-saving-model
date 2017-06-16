<?php

use yii\helpers\Url;

class DatepickerWidgetCest
{
    protected $inputDate;

    protected $timeFormat = [
        'input[name="WidgetModel[test]"]'     => 'Y-m-d',
        'input[name="WidgetModel[text]"]'     => 'Y-m-d H:i:s',
        'input[name="WidgetModel[textNext]"]' => 'g:i A',
    ];

    public function _before(AcceptanceTester $i)
    {
        $i->amOnPage(Url::to('/site/datepicker'));
        sleep(1);
        date_default_timezone_set('Europe/Kiev');
    }

    public function setDateTest(AcceptanceTester $i)
    {
        $this->checkField($i,'input[name="WidgetModel[test]"]');
        $this->checkField($i,'input[name="WidgetModel[text]"]');
        $this->checkField($i,'input[name="WidgetModel[textNext]"]');
    }

    protected function checkField(AcceptanceTester $tester, $selector)
    {
        $tester->canSeeElement($selector);
        $tester->click($selector);
        $this->inputDate = date($this->timeFormat[$selector], time());
        $tester->seeInField($selector, $this->inputDate);
        sleep(1);
        $tester->canSeeElement('div .bootstrap-datetimepicker-widget');
    }
}
