<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\relations\widgets\helpers;

use yii\helpers\FileHelper as BaseFileHelper;
use yii\i18n\Formatter;

/**
 * Class FileHelper
 *
 * @package sonrac\relations
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class FileHelper extends BaseFileHelper
{
    public static function generateDeepPath($basePath = null, $autoCreate = false, $maxFiles = 2000)
    {
        $basePath = $basePath ?? '';

        $time = time();

        while ($time > $maxFiles) {
            $basePath .= '/' . ($time % $maxFiles);

            $time /= 300;
        }

        if (!is_dir($basePath) && $autoCreate) {
            static::createDirectory($basePath);
        }

        return $basePath;

    }

    /**
     * Method: getName
     *
     * @param $path
     *
     * @return string
     * @author Bajadev <info@bajadev.hu>
     * @link   http://bajadev.hu
     */
    public static function getName($path)
    {
        return basename($path);
    }

    /**
     * Method: getHeight
     *
     * @param $path
     *
     * @return mixed
     * @author Bajadev <info@bajadev.hu>
     * @link   http://bajadev.hu
     */
    public static function getHeight($path)
    {
        $data = getimagesize($path);
        return $data[1];
    }

    /**
     * Method: getWidth
     *
     * @param $path
     *
     * @return mixed
     * @author Bajadev <info@bajadev.hu>
     * @link   http://bajadev.hu
     */
    public static function getWidth($path)
    {
        $data = getimagesize($path);
        return $data[0];
    }

    /**
     * Method: getSize
     *
     * @param $path
     *
     * @return string
     * @author Bajadev <info@bajadev.hu>
     * @link   http://bajadev.hu
     */
    public static function getSize($path)
    {
        $formatter = new Formatter();
        $formatter->sizeFormatBase = 1000;
        return $formatter->asShortSize(filesize($path), 0);
    }

    public static function getCreatedDate($path)
    {
        $date = filemtime($path);
        $formatter = new Formatter();
        $date = $formatter->asDate($date, 'yy.MMMM dd. HH:mm');
        return $date;
    }
}