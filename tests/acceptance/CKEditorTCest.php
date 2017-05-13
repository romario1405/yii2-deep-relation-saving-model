<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

use yii\helpers\Url;

/**
 * Class CKEditorTCest
 *
 * @package sonrac\relations\tests\functional\widgets
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class CKEditorTCest
{
    public function _before(AcceptanceTester $i) {
        sleep(2);
        $i->amOnPage(Url::to(['/site/ck']));
    }

    public function uploadFileWidgetTest(AcceptanceTester $i) {
        $i->canSeeElement('.cke_button__image');
        $i->click('.cke_button__image');
        $i->click('Upload');
        sleep(2);
        $i->executeJS('jQuery("iframe.cke_dialog_ui_input_file").attr("name", "ui-iframe")');
        $i->switchToIFrame('ui-iframe');
        $i->attachFile(['css' => 'input[name="upload"]'], 'cat.jpg');
        sleep(1);
        $i->switchToWindow();
        $i->click('Send it to the Server');
        sleep(1);
        $i->seeElement('.ImagePreviewBox');
    }

    public function browseFilesTest(AcceptanceTester $i) {

    }
}