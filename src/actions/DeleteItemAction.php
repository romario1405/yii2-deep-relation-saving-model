<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\relations\actions;

use sonrac\relations\TRelation;
use yii\base\Action;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;


/**
 * Class DeleteItemAction
 *
 * @package sonrac\relations\actions
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class DeleteItemAction extends Action
{
    /**
     * @var string Model class for delete record
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $modelClass;

    /**
     * @var bool Delete without relations if false or with relations if true and if modelCLass has trait TRelation
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $safeDelete = false;

    /**
     * Run action
     *
     * @param int $id
     *
     * @return bool
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function run($id)
    {
        return $this->remove($id);
    }

    /**
     * Remove data
     *
     * @param int $id ID record
     *
     * @return bool
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected function remove($id)
    {
        /** @var ActiveRecord|TRelation $class */
        $class = $this->findModel($id);
        if ($this->safeDelete && method_exists($class . 'rDeleteAll')) {
            return $class->rDeleteAll();
        }

        if (!$this->safeDelete) {
            return $class->delete() !== false;
        }

        $class->deleted_at = time();

        return $class->save();
    }

    /**
     * Find model by PK
     *
     * @param int $id Model primary key
     *
     * @return ActiveRecord
     *
     * @throws NotFoundHttpException
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected function findModel($id)
    {
        /** @var ActiveRecord $class */
        $class = $this->modelClass;
        if ($model = $class::findOne($id)) {
            return $model;
        }

        throw new NotFoundHttpException;
    }
}