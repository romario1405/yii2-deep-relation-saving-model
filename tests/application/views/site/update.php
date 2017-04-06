<?php
/**
 * Created by PhpStorm.
 * User: Donii Sergii
 * Date: 4/25/17
 * Time: 4:58 PM
 */

/**
 * @var \sonrac\relations\tests\application\models\Article $model
 */
?>

<h1>Update article <?= $model->id; ?></h1>

<?php
echo $this->render('_form', [
    'model' => $model,
]);
