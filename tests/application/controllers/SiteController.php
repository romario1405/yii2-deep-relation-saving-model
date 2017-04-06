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
    public function actionCreate() {
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
    public function actionUpdate($id) {
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
    protected function findModel(int $id) {
        $model = Article::findOne($id);

        if (is_null($model)) {
            throw new yii\web\NotFoundHttpException('Page not found');
        }

        return $model;
    }


}