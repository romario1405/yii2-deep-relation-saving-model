<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\tabularWidgets\ckEditor\actions;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;
use SplFileInfo;
use yii;
use yii\web\ViewAction;
use yii\widgets\LinkPager;

/**
 * Class CKFindFilesAction
 *
 * @package sonrac\tabularWidgets\ckEditor\actions
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class CKFindFilesAction extends ViewAction
{
    protected static $_cache = [];
    /**
     * Total files count
     *
     * @var null|int
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected static $_total = null;
    /**
     * Limit files to one touch
     *
     * @var int
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $limit;
    /**
     * Source dir
     *
     * @var string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $sourceDir = '@webroot/images/ck';
    /**
     * Allowed extensions to view in list
     *
     * @var null|array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $allowedExtensions = null;
    /**
     * Root url
     *
     * @var string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $rootUrl = '@web/images/ck';

    public $view = '@vendor/sonrac/yii2-relation-trait/src/widgets/tabularWidgets/ckEditor/actions/views/list';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->limit = $this->limit ?? 30;

        $this->sourceDir = Yii::getAlias($this->sourceDir);

        if (!static::$_cache) {
            if (!Yii::$app->session->has(static::generateCacheKey($this->sourceDir))) {
                $this->scanFiles($this->sourceDir);
            } else {
                static::$_cache = Yii::$app->session->get(static::generateCacheKey($this->sourceDir));
            }
        }
    }

    protected static function generateCacheKey($sourceDir)
    {
        return 'ck_filesystem_cache_' . md5($sourceDir);
    }

    /**
     * Scan files
     *
     * @param string $dir
     *
     * @return array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected function scanFiles($dir)
    {
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
        static::$_cache = [];
        $Directory = new RecursiveDirectoryIterator($dir);
        $Iterator = new RecursiveIteratorIterator($Directory);
        $extensionList = is_string($this->allowedExtensions) ? $this->allowedExtensions : implode('|', $this->allowedExtensions);
        $Regex = new RegexIterator($Iterator, '#^(?:[A-Z]:)?(?:/(?!\.Trash)[^/]+)+/[^/]+\.(?:' . $extensionList . ')$#Di', RecursiveRegexIterator::GET_MATCH);

        $files = [];

        foreach ($Regex as $item) {
            if (!count($item) || (!isset($item[0])) || (isset($item[0]) && (!is_file($item[0]) || is_dir($item[0])))) {
                continue;
            }

            static::addToCache($item[0], $dir);
        }

        static::regenerateCache($dir);

        return $files;

    }

    /**
     * Add file to cache
     *
     * @param string $file           Full filename
     * @param string $sourceDir      Source dir
     * @param bool   $replaceSession Replace value in session
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public static function addToCache($file, $sourceDir, $replaceSession = false)
    {
        /** @var SplFileInfo $item */
        $item = new SplFileInfo($file);

        $fileInfo = [
            'filename' => $item->getBasename(),
            'path'     => str_replace($sourceDir, '', $item->getPath()),
            'realPath' => $item->getPath(),
            'mime'     => mime_content_type($item->getPathname()),
            'ext'      => $item->getExtension(),
            'name'     => $item->getFilename(),
        ];
        static::$_cache[] = $fileInfo;

        if ($replaceSession) {
            Yii::$app->session->set(static::generateCacheKey($sourceDir), static::$_cache);
        }
    }

    /**
     * Regenerate cache from source dir
     *
     * @param string $sourceDir
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public static function regenerateCache($sourceDir)
    {
        static::resetCache($sourceDir);

        Yii::$app->session->set(static::generateCacheKey($sourceDir), static::$_cache);
        static::$_total = null;
    }

    /**
     * Reset cache
     *
     * @param string $sourceDir Source dir
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public static function resetCache($sourceDir)
    {
        if (!Yii::$app->session->has($key = static::generateCacheKey($sourceDir))) {
            Yii::$app->session->remove($key);
            static::$_total = 0;
        }
    }

    /**
     * Run action
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function run()
    {
        $this->scanFiles($this->sourceDir);
        if (!static::$_total) {
            static::$_total = count(static::$_cache);
        }

        $pagination = new yii\data\Pagination([
            'totalCount'    => static::$_total,
            'pageSizeLimit' => $this->limit,
        ]);

        $pager = new LinkPager([
            'pagination' => $pagination,
        ]);

        $items = [];

        $page = Yii::$app->request->get('page');

        if (($start = ($page * $this->limit)) < static::$_total) {
            for ($i = $start; $i < ((int)$start + (int)$this->limit); $i++) {
                $items[] = static::$_cache[$i];
            }
        }

        return $this->controller->render($this->view, [
            'pager' => $pager,
            'items' => $items,
        ]);
    }
}