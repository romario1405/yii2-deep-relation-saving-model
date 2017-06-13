<?php
/**
 * Created by PhpStorm.
 * User: Donii Sergii
 * Date: 4/4/17
 * Time: 2:50 PM
 */

namespace sonrac\relations\tests\application\controllers;


use sonrac\relations\tests\application\models\Article;
use sonrac\relations\tests\application\models\search\ArticleSearch;
use sonrac\relations\tests\application\models\WidgetModel;
use sonrac\tabularWidgets\ckEditor\actions\CKEditorFileBrowser;
use sonrac\tabularWidgets\ckEditor\actions\CKFindFilesAction;
use sonrac\tabularWidgets\ckEditor\actions\CKImageUploaderAction;
use yii;
use yii\web\Controller;

/**
 * Class SiteController
 * Site controller
 *
 * @package sonrac\relations\tests\application\controllers
 */
class SiteController extends Controller
{
    /**
     * Additional actions
     *
     * @return array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function actions()
    {
        return [
            'ck-view'       => [
                'class' => CKEditorFileBrowser::class,
                'view'  => '/../../../src/widgets/tabularWidgets/ckEditor/actions/views/view',
            ],
            'ck-upload'     => [
                'class' => CKImageUploaderAction::class,
            ],
            'ck-scan-files' => [
                'class'             => CKFindFilesAction::class,
                'sourceDir'         => '@webroot/images/ck',
                'allowedExtensions' => ['jpg', 'png', 'php'],
            ],
            'browse-images' => [
                'class'     => 'bajadev\ckeditor\actions\BrowseAction',
                'quality'   => 80,
                'maxWidth'  => 800,
                'maxHeight' => 800,
                'useHash'   => true,
                'url'       => '@web/images/ck',
                'path'      => '@webroot/images/ck/',
            ],
            'upload-images' => [
                'class'     => 'bajadev\ckeditor\actions\UploadAction',
                'quality'   => 80,
                'maxWidth'  => 800,
                'maxHeight' => 800,
                'useHash'   => true,
                'url'       => '@web/contents/',
                'path'      => '@frontend/web/contents/',
            ],
        ];
    }

    /**
     * Index action
     *
     * @throws yii\base\InvalidParamException
     *
     * @return string|yii\web\Response
     */
    public function actionIndex()
    {
        $search = new ArticleSearch();

        return $this->render('index', [
            'model'        => $search,
            'dataProvider' => $search->search(Yii::$app->request->post()),
        ]);
    }

    /**
     * Action create
     *
     * @throws yii\base\InvalidParamException
     *
     * @return string|yii\web\Response
     */
    public function actionCreate()
    {
        $article = new Article();

        if ($article->loadAll(Yii::$app->request->post()) && $article->validateAll() && $article->saveAll()) {
            return $this->redirect('index');
        }

        return $this->render('create', [
            'model' => $article,
        ]);
    }

    /**
     * Update article
     *
     * @param int $id
     *
     * @throws yii\base\InvalidParamException
     *
     * @return string|yii\web\Response
     */
    public function actionUpdate($id)
    {
        $article = $this->findModel((int)$id);

        if ($article->loadAll(Yii::$app->request->post()) && $article->validateAll() && $article->saveAll()) {
            return $this->redirect('index');
        }

        return $this->render('create', [
            'model' => $article,
        ]);
    }

    /**
     * Find model
     *
     * @param int $id
     *
     * @return Article
     *
     * @throws yii\web\NotFoundHttpException
     */
    protected function findModel(int $id)
    {
        $model = Article::findOne($id);

        if (is_null($model)) {
            throw new yii\web\NotFoundHttpException('Page not found');
        }

        return $model;
    }

    /**
     * CKEditor action
     *
     * @return string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function actionCk()
    {
        return $this->render('widgets/ckeditor', [
            'model' => new WidgetModel(),
        ]);
    }

    /**
     * Select2 action
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function actionSelect2()
    {
        return $this->render('widgets/select2', [
            'model'  => new WidgetModel(),
        ]);
    }

    /**
     * Date picker widget option
     *
     * @return string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function actionDatepicker() {
        return $this->render('widgets/datepicker', [
            'model' => new WidgetModel(),
        ]);
    }

    /**
     * Color input text
     *
     * @return string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function actionColor() {
        return $this->render('widgets/colorPicker', [
            'model' => new WidgetModel(),
        ]);
    }

    /**
     * Date range picker action
     *
     * @return string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function actionDaterange() {
        return $this->render('widgets/daterange', [
            'model' => new WidgetModel()
        ]);
    }

    /**
     * Rating widget action
     *
     * @return string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function actionRating() {
        return $this->render('widgets/rating', [
            'model' => new WidgetModel()
        ]);
    }

    /**
     * Rating widget action
     *
     * @return string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function actionRange() {
        return $this->render('widgets/range', [
            'model' => new WidgetModel()
        ]);
    }

    public function actionTest()
    {
        return $this->render('test', [
            'model' => new WidgetModel(),
        ]);
    }


}