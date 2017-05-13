<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\tabularWidgets\ckEditor;

use sonrac\tabularWidgets\BaseWidget;
use sonrac\tabularWidgets\ITabularWidget;
use yii\helpers\Url;
use yii\web\JsExpression;

/**
 * Class CKEditorTabular
 *
 * @package sonrac\tabularWidgets
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class CKEditorTabular extends BaseWidget implements ITabularWidget
{
    /**
     * Widget assets bundle
     *
     * @var string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $assetsBundles = 'sonrac\tabularWidgets\ckEditor\CKEditorAssets';

    public $fieldType = 'textArea';

    public $fileBrowserAction = null;

    public $fileUploadAction = null;

    public function init()
    {
        parent::init();

        if (!empty($this->fileBrowserAction)) {
            $this->fileBrowserAction = Url::to($this->fileBrowserAction);
            $this->pluginOptions['filebrowserBrowseUrl'] = $this->fileBrowserAction;
        }

        if (!empty($this->fileUploadAction)) {
            $this->fileUploadAction = Url::to($this->fileUploadAction);
            $this->pluginOptions['filebrowserUploadUrl'] = $this->fileUploadAction;
        }
    }

    /**
     * @inheritdoc
     */
    public function getInitScript(): string
    {

        \Yii::$app->controller->view->registerJs('
        $(document).off(\'click\', \'.cke_dialog_tabs a[id^="cke_Upload_"]\').on(\'click\', \'.cke_dialog_tabs a[id^="cke_Upload_"]\', function () {
            var $forms = $(\'.cke_dialog_ui_input_file iframe\').contents().find(\'form\');
            var csrfName = yii.getCsrfParam();
            $forms.each(function () {
                if (!$(this).find(\'input[name=\' + csrfName + \']\').length) {
                    var csrfTokenInput = $(\'<input/>\').attr({
                        \'type\': \'hidden\',
                        \'name\': csrfName
                    }).val(yii.getCsrfToken());
                    $(this).append(csrfTokenInput);
                }
            });
        });
        ');

        return (new JsExpression("CKEDITOR.replace(id, options);"));
    }

}