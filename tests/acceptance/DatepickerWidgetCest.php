<?php

use yii\helpers\Url;

class DatepickerWidgetCest
{
    public function _before(AcceptanceTester $i)
    {
        $i->amOnPage(Url::to('/site/datepicker'));
        sleep(3);
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
        sleep(1);
        $tester->canSeeElement('div .bootstrap-datetimepicker-widget');
        sleep(1);
        $tester->seeInField('input[name="WidgetModel[test]"]', '');
    }
}
