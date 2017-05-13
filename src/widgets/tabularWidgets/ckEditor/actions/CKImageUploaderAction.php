<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\tabularWidgets\ckEditor\actions;

use sonrac\tabularWidgets\ckEditor\models\CKUpload;
use yii;
use yii\base\Action;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * Class UploaderAction
 *
 * @package sonrac\tabularWidgets\actions
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class CKImageUploaderAction extends Action
{
    /**
     * Upload path
     *
     * @var string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $uploadPath = '@webroot/uploaded/ck';

    /**
     * Upload url
     *
     * @var string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $uploadedUrl = '@web/uploaded/ck';

    /**
     * Allowed file extensions
     *
     * @var string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $allowedExtensions = 'png, jpg, jpeg, gif, ico';

    /**
     * Change language by CK editor options
     *
     * @var bool
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $enableChangeLanguage = false;

    /**
     * Use file browser extension. Adding file to cache before upload
     *
     * @var bool
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $useBrowserAction = true;

    public function init()
    {
        $this->uploadPath = Yii::getAlias($this->uploadPath);
        $this->uploadedUrl = Yii::getAlias($this->uploadedUrl);
    }

    /**
     * Run upload action
     */
    public function run()
    {
        $model = new CKUpload([
            'allowedExtensions' => $this->allowedExtensions,
        ]);

        $request = Yii::$app->request;

        if ($this->enableChangeLanguage && ($locale = $request->get('locale'))) {
            $this->changeLanguage($locale);
        }

        $post = array_merge(Yii::$app->request->post(), ['uploadedFile' => UploadedFile::getInstanceByName('upload')]);

        $message = $url = $function = '';
        if (!is_null($function = $request->get('CKEditorFuncNum'))) {

            if ($model->load($post, '') && $model->validate()) {
                if (!$model->uploadedFile->hasError) {
                    $filename = $this->generateFileName($model->uploadedFile->name);
                    $url = "{$this->uploadedUrl}/{$filename}";

                    if (!is_dir($this->uploadPath)) {
                        FileHelper::createDirectory($this->uploadPath);
                    }

                    if (!$model->uploadedFile->saveAs($savedFile = $this->uploadPath . "/{$filename}")) {
                        $url = '';
                        $message = implode("\n", $model->getFirstErrors());
                        if ($this->useBrowserAction) {
                            CKFindFilesAction::addToCache($savedFile, $this->uploadPath, true);
                        }
                    } else {
                        $message = '';
                    }
                } else {
                    $message = Yii::t('sonrac-relations', 'Error uploading file');
                }
            } else {
                $message = implode("\n", $model->getFirstErrors());
            }
        }

        return $this->returnResult($function, $url, $message);

    }

    /**
     * Change response language
     *
     * @param $locale
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected function changeLanguage($locale)
    {
        Yii::$app->language = $locale;
    }

    /**
     * Generate runtime filename
     *
     * @param string $name
     *
     * @return string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected function generateFileName($name)
    {
        return md5(time() . '_' . $name);
    }

    /**
     * Return answer to ckeditor
     *
     * @param string $function Function name
     * @param string $url      Uploaded url
     * @param string $content  Messages
     *
     * @return string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected function returnResult($function, $url, $content)
    {
        $function = $function ?? '$';
        return "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction({$function}, '{$url}', '{$content}'); </script>";
    }
}