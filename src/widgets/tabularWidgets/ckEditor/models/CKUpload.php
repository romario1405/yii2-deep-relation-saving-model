<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\tabularWidgets\ckEditor\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class CKUpload
 * CK upload model
 *
 * @property UploadedFile $uploadedFile                    Uploaded file from request
 * @property array        $allowedExtensions               Allowed extensions for uploaded file
 *
 * @package sonrac\tabularWidgets\ckEditor\models
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class CKUpload extends Model
{
    /**
     * Uploaded file
     *
     * @var UploadedFile
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $uploadedFile;

    /**
     * Uploaded file allowed extensions
     *
     * @var string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $allowedExtensions = 'png, jpg, jpeg, gif, ico';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $extensions = is_array($this->allowedExtensions) ? implode(', ', $this->allowedExtensions) : $this->allowedExtensions;
        return [
            ['uploadedFile', 'required'],
            ['uploadedFile', 'file', 'skipOnEmpty' => false, 'extensions' => $extensions],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'upload' => Yii::t('sonrac-relations', 'File'),
        ];
    }
}