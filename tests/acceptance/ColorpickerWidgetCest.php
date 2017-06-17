<?php

use yii\helpers\Url;

class ColorpickerWidgetCest
{
    public function _before(AcceptanceTester $i)
    {
        $i->amOnPage(Url::to(['/site/color']));
        sleep(1);
    }

    public function checkColorSelectTest(AcceptanceTester $i)
    {
        $i->click('input[name="WidgetModel[text]"]');
        sleep(1);
        $i->seeElement('.colorpicker');
        $i->click(['id' => 'rgb_r']);
        sleep(2);
        $i->fillField('input[id=rgb_r]', 214);
        sleep(2);
        $i->click(['id' => 'rgb_r']);
        $i->fillField(['id' => 'rgb_g'], 219);
        sleep(2);
        $i->click(['id' => 'rgb_r']);
        $i->fillField(['id' => 'rgb_b'], 158);
        sleep(2);
    }
}
