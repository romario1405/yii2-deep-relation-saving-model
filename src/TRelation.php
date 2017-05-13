<?php
/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 4/3/17
 * Time: 21:36
 *
 * @author Doniy Serhey <doniysa@gmail.com>
 */


namespace sonrac\relations;

use yii\db\Connection;

/**
 * Class TRelation
 *
 * @package sonrac\relations
 *
 * @author  Doniy Serhey <doniysa@gmail.com>
 */
trait TRelation
{
    /**
     * User's config skip relations for auto load relations
     *
     * @var array
     *
     * @author Doniy Serhey <doniysa@gmail.com>
     */
    public $skipRelations = [];

    /**
     * Skip methods for parse in model
     *
     * @var array
     */
    public $skipMethods = [];

    /**
     * Deleting error in transaction
     *
     * @var array
     */
    public $relationDeleteErrors = [];
    /**
     * List of validate model function which calling instead validate if method exist in model
     *
     * @var array
     */
    public $validateMethods = ['tValidate'];
    /**
     * If true - changed scenario for all relations which are loaded
     *
     * @var bool
     */
    public $changeRelationsScenario = true;
    /**
     * All models errors
     *
     * @var array
     *
     * @author Doniy Serhey <doniysa@gmail.com>
     */
    public $stackErrors = [];
    /**
     * Last relation query
     *
     * @var \yii\db\ActiveQuery
     */
    protected $_lastQuery;
    /**
     * Skip methods list from \yii\db\ActiveRecord
     *
     * @var array
     *
     * @author Doniy Serhey <doniysa@gmail.com>
     */
    private $_skipMethods
        = [
            'getTableSchema', 'getDb', 'getRelatedRecords', 'getPrimaryKey', 'getOldPrimaryKey', 'getRelation',
            'getAttributeLabel', 'getAttributeHint', 'getAttribute', 'getAttributes', 'getOldAttributes',
            'getOldAttribute', 'getDirtyAttributes', 'getIsNewRecord',
        ];
    /**
     * Saving primary keys. Be cleaning after and before saveAll
     * Format:
     * [
     *      '<class_name>' => [
     *          [
     *              'field1' => 'value',
     *              'field2' => 'value',
     *          ], ...
     *      ]
     * ]
     *
     * @var array
     */
    private $existingPKS = [];
    /**
     * Link relation attribute
     *
     * @var array
     */
    private $linkAttributes = [];

    /**
     * Saves the current record with all relations
     *
     * This method will call [[insert()]] when [[isNewRecord]] is `true`, or [[update()]]
     * when [[isNewRecord]] is `false`.
     *
     * For example, to save a customer record:
     *
     * ```php
     * $customer = new Customer; // or $customer = Customer::findOne($id);
     * $customer->name = $name;
     * $customer->email = $email;
     * $customer->save();
     * ```
     *
     * @param bool  $runValidation  whether to perform validation (calling [[validate()]])
     *                              before saving the record. Defaults to `true`. If the validation fails, the record
     *                              will not be saved to the database and this method will return `false`.
     * @param array $attributeNames list of attribute names that need to be saved. Defaults to null,
     *                              meaning all attributes that are loaded from DB will be saved.
     *
     * @return bool whether the saving succeeded (i.e. no validation errors occurred).
     */
    public function saveAll($runValidation = true, $attributeNames = null)
    {
        $this->existingPKS = [];
        /** @var $this \yii\db\ActiveRecord */
        /** @var \yii\db\Transaction $transaction */
        $transaction = $this->getDB()->beginTransaction();

        $this->linkAttributes = [];

        if ($this->saveModel($runValidation, $attributeNames, $this)) {

            $result = $this->recSaveModel($this, []);

            if ($result) {
                $this->dropNotSavedData();
                $transaction->commit();
                $this->existingPKS = [];

                return true;
            }
        }

        $transaction->rollback();
        $this->existingPKS = [];

        return false;
    }

    /**
     * Save new model or update if exists
     *
     * @param bool                 $runValidation  whether to perform validation (calling [[validate()]])
     *                                             before saving the record. Defaults to `true`. If the validation
     *                                             fails, the record will not be saved to the database and this method
     *                                             will return `false`.
     * @param array                $attributeNames list of attribute names that need to be saved. Defaults to null,
     *                                             meaning all attributes that are loaded from DB will be saved.
     *
     * @param \yii\db\ActiveRecord $model          Model for save
     *
     * @return bool
     */
    protected function saveModel($runValidation, &$attributeNames, &$model)
    {
        $result = true;
        if ($model->isNewRecord || count($model->dirtyAttributes)) {
            $result = $model->isNewRecord ? $model->save($runValidation, $attributeNames) : $model->update($runValidation, $attributeNames);
            if (count($model->errors)) {
                $this->stackErrors[] = [
                    'class'  => $model->class,
                    'errors' => $model->errors,
                ];
            }
        }

        /** @var \yii\db\ActiveRecord|string $class */
        $class = $model::className();
        if (!isset($this->existingPKS[$class])) {
            $this->existingPKS[$class] = [];
        }

        $pks = [];

        foreach ($class::primaryKey() as $field) {
            $pks[$field] = $model->{$field};
        }

        if (!in_array($pks, $this->existingPKS[$class])) {
            $this->existingPKS[$class][] = $pks;
        }

        return (is_bool($result) ? $result : is_numeric($result));
    }

    /**
     * Recursion save model with all relations
     *
     * @param \yii\db\ActiveRecord $model          Model save
     * @param array                $linkAttributes Link relation attributes
     * @param bool                 $runValidation  Run validation
     * @param array                $attributes     Attributes changing
     *
     * @return bool
     *
     * @author Doniy Serhey <doniysa@gmail.com>
     */
    protected function recSaveModel($model, array $linkAttributes, $runValidation = true, $attributes = null)
    {
        if (count($linkAttributes)) {
            foreach ($linkAttributes as $linkAttribute => $value) {
                $model->{$linkAttribute} = $value;
            }
        }
        $result = $this->saveModel($runValidation, $attributes, $model);
        if (count($model->relatedRecords)) {
            foreach ($model->relatedRecords as $relationName => $relatedRecord) {
                $relInfo = $model->getRelation($relationName);
                $link = $relInfo->link;

                $linkAttributes = [];
                foreach ($link as $attribute => $value) {
                    $linkAttributes[$attribute] = $model->{$value};
                }

                if (is_array($relatedRecord)) {
                    foreach ($relatedRecord as $record) {
                        $result = $this->recSaveModel($record, $linkAttributes, $runValidation, $attributes) && $result;
                    }
                } else {
                    $result = $this->recSaveModel($relatedRecord, $linkAttributes, $runValidation, $attributes) && $result;
                }
            }
        }

        return $result;
    }

    /**
     * Drop not existing records after save
     */
    private function dropNotSavedData($notDeletedQueries = null, $currentRetry = 0, $maxRetry = 10)
    {
        if ($currentRetry > $maxRetry) {
            return;
        }
        $notDeletedQueries = $notDeletedQueries ?? $this->existingPKS;
        $notDeletedQueriesCurrent = [];
        if (count($notDeletedQueries)) {
            foreach ($notDeletedQueries as $class => $pks) {
                /** @var \yii\db\ActiveRecord $class */

                $condition = ['and'];

                foreach ($pks as $nextPK) {
                    foreach ($nextPK as $pk => $value) {
                        $condition[] = ['!=', $pk, $value];
                    }
                }

                try {
                    $class::getDb()->createCommand()
                        ->delete($class::tableName(), $condition)->execute();
                } catch (\Exception $exception) {
                    if (!isset($notDeletedQueriesCurrent[$class])) {
                        $notDeletedQueriesCurrent[$class] = [];
                    }

                    $notDeletedQueriesCurrent[$class][] = $this->existingPKS;
                }
            }
        }

        if (count($notDeletedQueriesCurrent)) {
            $this->dropNotSavedData($notDeletedQueriesCurrent, ++$currentRetry);
        }
    }

    /**
     * Load data in model with relations
     *
     * @param array                     $data
     * @param null|\yii\db\ActiveRecord $context
     *
     * @return bool
     */
    public function loadAll(array $data = [], &$pContext = null)
    {
        if (!count($data)) {
            return false;
        }

        /** @var $this \yii\db\ActiveRecord */
        $pContext = $pContext ?? $this;

        $successLoad = true;

        foreach ($data as $name => $datum) {
            $datum = !is_array($datum) ? [$name => $datum] : $datum;
            if ($this->loadRelation($name, $datum, $pContext) === false) {
                $successLoad = $pContext->load($datum, '') && $successLoad;
            }
        }

        return $successLoad;
    }

    /**
     * Load relation in model
     * Change scenario for all relations if [[changeRelationsScenario]] is true
     *
     * @see \sonrac\relations\TRelation::changeRelationsScenario
     *
     * @param string                    $relationName Relation name
     * @param array                     $data         Relation data
     * @param null|\yii\db\ActiveRecord $context      Context loading
     *
     * @return bool
     */
    public function loadRelation(string $relationName, array $data, &$context = null)
    {
        $relationName = lcfirst($relationName);
        if (!count($data)) {
            return false;
        }

        /** @var $this \yii\db\ActiveRecord */
        $context = $context ?? $this;
        /** @var \yii\db\ActiveQuery $relation */
        if (!($relation = $this->checkRelationExist($relationName, $context))) {
            return false;
        }

        $context = $context ?? $this;

        $hasMany = $relation->multiple;

        $existsRelations = $hasMany ? [] : null;

        if (!$context->isNewRecord) {
            $existsRelations = $hasMany ? $relation->all() : $relation->one();
        }

        $data = $hasMany && !is_array(current($data)) ? [$data] : $data;

        /** @var \yii\db\ActiveRecord|\yii\db\ActiveRecord[] $newModels */
        $newModels = [];

        /** @var string|\yii\db\ActiveRecord $class */
        $class = $relation->modelClass;
        $pks = $class::primaryKey();

        /** @var array $linkAttributes */
        $linkAttributes = $this->generateLinkAttributesForModel($context, $relation->link);

        if ($hasMany) {
            foreach ($data as $index => $datum) {
                if ($context->isNewRecord) {
                    $newModels[$index] = new $class;
                } else {
                    $pkAttributes = [];
                    foreach ($pks as $pk) {
                        if (isset($datum[$pk])) {
                            $pkAttributes[$pk] = $datum[$pk];
                        }
                    }
                    $newModels[$index] = $this->findExistRecordInRelation($existsRelations, $linkAttributes, $pkAttributes) ?: new $class();
                }
                $this->loadAll($datum, $newModels[$index]);
                if ($this->changeRelationsScenario) {
                    $newModels[$index]->setScenario($context->getScenario());
                }
                $newModels[$index]->setAttributes($linkAttributes, '');
            }
        } else {
            $newModels = $existsRelations ?? new $class();
            $this->loadAll($data, $newModels);
            $newModels->setAttributes($linkAttributes, '');
            if ($this->changeRelationsScenario) {
                $newModels->setScenario($context->getScenario());
            }
        }

        $context->populateRelation($relationName, $newModels);

        return true;
    }

    /**
     * Check exists relation
     *
     * @param string                    $name    Relation name
     * @param null|\yii\db\ActiveRecord $context Context find
     *
     * @return bool|\yii\db\ActiveQuery
     */
    public function checkRelationExist(string $name, $context = null)
    {
        /** @var \yii\db\ActiveRecord $context */
        /** @var \yii\db\ActiveRecord $this */
        $context = $context ?? $this;

        $method = 'get' . ucfirst($name);

        if (!method_exists($context, $method) || $this->checkInSkip($name)) {
            return false;
        }

        try {
            $query = $context->$method();

            if ($query instanceof \yii\db\ActiveQuery) {
                return $query;
            }

            return false;
        } catch (\Exception $exception) {
        }

        return false;
    }

    /**
     * Check skip relations
     *
     * @param string $name
     *
     * @return bool
     */
    protected function checkInSkip(string $name)
    {
        $method = 'get' . ucfirst($name);
        if (in_array($method, $this->skipMethods) || in_array($method, $this->_skipMethods)) {
            return true;
        }

        $_name = [ucfirst($name), lcfirst($name)];

        foreach ($_name as $item) {
            if (in_array($item, $this->_skipMethods) || in_array($item, $this->skipRelations)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Generate link
     *
     * @param \yii\db\ActiveRecord $model Base model
     * @param array                $link  Link attributes
     *
     * @return array
     */
    public function generateLinkAttributesForModel(\yii\db\ActiveRecord $model, array $link)
    {
        if ($model->isNewRecord) {
            return [];
        }

        $attributes = [];

        foreach ($link as $relModelAttribute => $modelAttribute) {
            $attributes[$relModelAttribute] = $model->{$modelAttribute};
        }

        return $attributes;
    }

    /**
     * Find existing record by primary key
     *
     * @param \yii\db\ActiveRecord|\yii\db\ActiveRecord[] $relations
     * @param array                                       $primaryKey     Primary key find
     * @param array                                       $linkAttributes Link model attributes
     *
     * @return bool|\yii\db\ActiveRecord
     */
    protected function findExistRecordInRelation(&$relations, array $primaryKey, array $linkAttributes)
    {
        if (is_array($relations)) {
            foreach ($relations as $relation) {
                if ($this->checkPrimaryKey($relation->attributes, $primaryKey) && $this->checkPrimaryKey($relation->attributes, $linkAttributes)) {
                    return $relation;
                }
            }
        }

        return false;
    }

    /**
     * Check exists and define primary key
     *
     * @param array $attributes Model attributes
     * @param array $primaryKey Primary key
     *
     * @return bool
     */
    protected function checkPrimaryKey(array $attributes, array $primaryKey)
    {
        if (!count($attributes) || !count($primaryKey)) {
            return false;
        }

        foreach ($primaryKey as $name => $value) {
            if (!isset($attributes[$name]) || !(isset($attributes[$name]) && $attributes[$name] == $value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Performs the data validation with all relations.
     *
     * This method executes the validation rules applicable to the current [[scenario]].
     * The following criteria are used to determine whether a rule is currently applicable:
     *
     * - the rule must be associated with the attributes relevant to the current scenario;
     * - the rules must be effective for the current scenario.
     *
     * This method will call [[beforeValidate()]] and [[afterValidate()]] before and
     * after the actual validation, respectively. If [[beforeValidate()]] returns false,
     * the validation will be cancelled and [[afterValidate()]] will not be called.
     *
     * Errors found during the validation can be retrieved via [[getErrors()]],
     * [[getFirstErrors()]] and [[getFirstError()]].
     *
     * @param array                     $attributeNames list of attribute names that should be validated.
     *                                                  If this parameter is empty, it means any attribute listed in
     *                                                  the applicable validation rules should be validated.
     * @param bool                      $clearErrors    whether to call [[clearErrors()]] before performing validation
     * @param null|\yii\db\ActiveRecord $pContext       Context call validate method
     *
     * @return bool whether the validation is successful without any error.
     * @throws \yii\base\InvalidParamException if the current scenario is unknown.
     */
    public function validateAll($attributeNames = null, $clearErrors = true, &$pContext = null)
    {
        $pContext = $pContext ?? $this;
        if (count($this->validateMethods)) {
            foreach ($this->validateMethods as $validateMethod) {
                if (method_exists($pContext, $validateMethod)) {
                    $result = $pContext->{$validateMethod}($attributeNames, $clearErrors);
                    break;
                }
            }
        }

        if (!isset($result)) {
            $result = $pContext->validate($attributeNames, $clearErrors);
        }

        if (!count($pContext->relatedRecords)) {
            return $result;
        }

        foreach ($pContext->relatedRecords as $relatedRecord) {
            if (is_array($relatedRecord)) {
                foreach ($relatedRecord as $_next) {
                    $result = $this->validateAll($attributeNames, $clearErrors, $_next);
                }
            } else {
                /** @var $relatedRecord \yii\db\ActiveRecord */
                $result = $this->validateAll($attributeNames, $clearErrors, $relatedRecord) && $result;
            }
        }

        return $result;
    }

    /**
     * Delete all with relation data
     *
     * @author Doniy Serhey <doniysa@gmail.com>
     */
    public function rDeleteAll()
    {
        /** Clear previous errors */
        $this->relationDeleteErrors = [];

        /** @var \yii\db\ActiveRecord $result */
        /** @var \yii\db\ActiveRecord $this */
        $result = true;

        /** @var Connection $connection */
        $connection = static::getDb();
        /** @var \yii\db\Transaction $transaction */
        $transaction = $connection->beginTransaction();
        $stack = new Stack();

        $stack = $this->deepModelsCircumventing($stack, $this);

        while (!$stack->isEmpty()) { // Drop all models in stack
            /** @var $elem \yii\db\ActiveRecord */
            $elem = $stack->pop();

            try {
                $result = $elem->delete() && $result;
            } catch (\Exception $e) { // If error rollback transaction and return false
                $this->relationDeleteErrors[] = $e->getMessage();
                $transaction->rollBack();

                return false;
            }
        }

        if ($result) {
            $transaction->commit();
        } else {
            $transaction->rollBack();
        }

        return $result;
    }

    /**
     * Models circumventing for delete/save
     * Begin deleting from end. @see \sonrac\relations\TRelation::rDeleteAll()
     *
     * @param \sonrac\relations\Stack $pStack      Stack models
     * @param \yii\db\ActiveRecord    $pRecord     Context records for drop relations
     * @param \Closure|null           $retFunction Return callback
     *
     * @return \sonrac\relations\Stack|bool
     */
    private function deepModelsCircumventing(&$pStack, $pRecord)
    {
        $pStack->push($pRecord);

        if (!count($pRecord->relatedRecords)) {
            $this->loadAllModelRelations($pRecord);
        }

        foreach ($pRecord->relatedRecords as $name => $relatedRecord) {
            if ($relatedRecord instanceof \yii\db\ActiveRecord) {
                $this->deepModelsCircumventing($pStack, $relatedRecord);
            }

            if (is_array($relatedRecord)) {
                foreach ($relatedRecord as $item) {
                    $this->deepModelsCircumventing($pStack, $item);
                }
            }
        }

        return $pStack;
    }

    /**
     * Force load all model relations
     *
     * @param null|\yii\db\ActiveRecord $pContext
     */
    public function loadAllModelRelations(&$pContext = null)
    {
        /** @var \yii\db\ActiveRecord $pContext */
        $pContext = $pContext ?? $this;
        $reflector = new \ReflectionClass(get_class($pContext));
        foreach ($reflector->getMethods() AS $method) { // Scan all methods with reflection
            $params = $method->getNumberOfRequiredParameters();
            $method = $method->getName();

            $relationName = lcfirst(str_replace('get', '', $method));

            /**
             * Skip methods with required params, defined in [[\sonrac\relations\TRelation::_skipMethods]] and non-getter function or relation loaded or populated
             */
            if (in_array($method, $this->_skipMethods) || strpos($method, 'get') !== 0 || ($params > 0) || isset($pContext->relatedRecords[$relationName])
                || in_array($relationName, $this->skipRelations) || in_array(ucfirst($relationName), $this->skipRelations)
            ) {
                continue;
            }

            try { // Check relation get
                $query = $this->{$method}();
                if ($query instanceof \yii\db\ActiveQuery) { // Load relation
                    $this->{$relationName};
                }
            } catch (\Exception $exception) {
                continue;
            }
        }
    }
}