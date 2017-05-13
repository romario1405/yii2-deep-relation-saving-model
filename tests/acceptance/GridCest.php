<?php
use yii\helpers\Url as Url;

class GridCest
{
    public function ensureThatAboutWorks(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/index'));
        $I->see('Create', 'a');
        $I->click('a');
        sleep(3);
    }
}