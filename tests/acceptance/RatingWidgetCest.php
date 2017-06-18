<?php

use yii\helpers\Url;

class RatingWidgetCest
{
    public function _before(AcceptanceTester $i)
    {
        $i->amOnPage(Url::to(['/site/rating']));
        sleep(1);
    }

    public function ratingWidgetTest(AcceptanceTester $i)
    {
        $i->canSeeElement('.br-widget');

        for ($j = 1; $j <= 10; $j++) {
            $i->click(".br-widget a[data-rating-value='{$j}']");
            sleep(1);
            $i->canSeeElement("a[data-rating-value='{$j}']", ['class' => 'br-selected br-current']);
            sleep(1);
        }
    }
}
