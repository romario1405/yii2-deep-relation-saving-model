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
        $i->canSeeElement('input[name="WidgetModel[test]"]');
        $i->canSeeElement('input[name="WidgetModel[text]"]');
        $i->canSeeElement('input[name="WidgetModel[textNext]"]');

        $i->click('input[name="WidgetModel[test]"]');
        sleep(1);
        $i->canSeeElement('div .bootstrap-datetimepicker-widget');
        sleep(1);
        $i->dontSeeInField('input[name="WidgetModel[test]"]', '');
        $i->click('input[name="WidgetModel[text]"]');
        sleep(1);
        $i->canSeeElement('div .bootstrap-datetimepicker-widget');
        sleep(1);
        $i->dontSeeInField('input[name="WidgetModel[text]"]', '');
        $i->click('input[name="WidgetModel[textNext]"]');
        sleep(1);
        $i->canSeeElement('div .bootstrap-datetimepicker-widget');
        sleep(1);
        $i->dontSeeInField('input[name="WidgetModel[textNext]"]', '');
    }
}
