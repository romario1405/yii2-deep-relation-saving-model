<?php
/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 4/3/17
 * Time: 21:32
 *
 * @author Doniy Serhey <doniysa@gmail.com>
 */

namespace sonrac\relations\tests\application\models\search;

use sonrac\relations\tests\application\models\Article;
use yii\data\ActiveDataProvider;

class ArticleSearch extends Article
{
    public function search($params)
    {
        $query = Article::find();

        $dataProvider = new ActiveDataProvider([
                                                   'query' => $query,
                                               ]);

        $this->loadAll($params);

        return $dataProvider;
    }
}