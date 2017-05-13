<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

use yii\helpers\Url;

/**
 * Class Select2WidgetCest
 *
 * @author Donii Sergii <doniysa@gmail.com>
 */
class Select2WidgetCest
{
    public function _before(AcceptanceTester $i) {
        $i->amOnPage(Url::to(['/site/select2']));
    }

    public function select2InitTest(AcceptanceTester $i) {
        $i->seeElement('.select2-selection__rendered');

        $i->see('Select item...');

        $i->click('.select2-selection--single');

        $i->see('1');
        $i->see('2');
        $i->selectOption('select', '1');

        $i->click('.select2-selection__clear');
    }
}