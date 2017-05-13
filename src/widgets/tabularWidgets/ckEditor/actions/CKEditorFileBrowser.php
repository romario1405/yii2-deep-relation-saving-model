<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\tabularWidgets\ckEditor\actions;

use Imagine\Image\Box;
use sonrac\relations\widgets\helpers\FileHelper;
use sonrac\tabularWidgets\ckEditor\models\CKUpload;
use yii;
use yii\base\Security;
use yii\imagine\Image;
use yii\web\ViewAction;

/**
 * Class CKEditorFileBrowser
 *
 * @package sonrac\tabularWidgets\actions
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class CKEditorFileBrowser extends ViewAction
{
    /**
     * Base Url
     *
     * @var string
     */
    public $url = '@web/images/ck';

    /**
     * Base Path
     *
     * @var string
     */
    public $path = '@webroot/images/ck';

    /**
     * @var int Max Width
     */
    public $maxWidth = 800;

    /**
     * Max Height
     *
     * @var int
     */
    public $maxHeight = 800;

    /**
     * image quality
     *
     * @var int
     */
    public $quality = 80;

    /**
     * Use Hash for filename
     *
     * @var bool
     */
    public $useHash = true;

    /**
     * Allowed extensions for browsing
     *
     * @var string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $allowedExtensions = 'png, jpg, jpeg, gif, ico';

    /**
     * View name
     *
     * @var string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $view = '@vendor/sonrac/yii2-relation-trait/src/widgets/tabularWidgets/ckEditor/actions/views/view';

    /**
     * @inheritdoc
     */
    public function run()
    {
        $path = FileHelper::generateDeepPath($this->getPath(), true);

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if (!empty($post['method'])) {
                $file = basename($post['file']);
                if (file_exists($this->getPath() . $file)) {
                    unlink($this->getPath() . $file);
                }
            } else {
                $model = new CKUpload();
                if ($model->load($post, '') && $model->validate()) {
                    $fileName = $this->getFileName($model->upload);
                    $model->upload->saveAs($path . '/' . $fileName);
                    $imagine = Image::getImagine();
                    $photo = $imagine->open($path . $fileName);
                    $photo->thumbnail(new Box($this->maxWidth, $this->maxHeight))
                        ->save($this->getPath() . $fileName, ['quality' => $this->quality]);
                } else {
                    echo "<script type='text/javascript'>alert('" . $model->getFirstError('upload') . "');</script>";
                    exit;
                }
            }
        }
//        BrowseAssets::register($this->controller->view);
//        $this->controller->layout = '@vendor/bajadev/yii2-ckeditor/views/layout/image';
        $images = FileHelper::findFiles($this->getPath(), ['recursive' => false]);
        return $this->controller->render($this->view, [
            'images' => $images,
            'url'    => $this->getUrl(),
        ]);
    }

    /**
     * @return string
     */
    private function getPath()
    {
        return Yii::getAlias($this->path);
    }

    /**
     * @param yii\web\UploadedFile $image
     *
     * @return string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    private function getFileName($image)
    {
        if ($this->useHash) {
            $security = new Security();
            $fileName = $security->generateRandomString(16);
            return $fileName . '.' . $image->getExtension();
        } else {
            return $image->name . '.' . $image->getExtension();
        }
    }

    /**
     * @return string
     */
    private function getUrl()
    {
        return Yii::getAlias($this->url);
    }
}