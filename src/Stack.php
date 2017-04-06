<?php
/**
 * Created by PhpStorm.
 * User: Donii Sergii
 * Date: 4/6/17
 * Time: 12:29 PM
 */

namespace sonrac\relations;

/**
 * Class Stack
 * Stack for relation models
 *
 * @package sonrac\relations
 */
class Stack implements IStack
{
    /**
     * Stack
     *
     * @var array
     */
    private $stack;

    /**
     * Limit elements. If is null - unlimited
     *
     * @var int
     */
    protected $limit;

    /**
     * Stack constructor.
     *
     * @inheritdoc
     */
    public function __construct($limit = null)
    {
        $this->stack = [];
        $this->limit = $limit;
    }

    /**
     * @inheritdoc
     */
    public function push(&$item)
    {
        if (is_null($this->limit) || (count($this->stack) < $this->limit)) {

            array_unshift($this->stack, $item);

            return;
        }

        throw new \RunTimeException('Stack is full!');
    }

    /**
     * @inheritdoc
     */
    public function pop()
    {
        if ($this->isEmpty()) {
            throw new \RunTimeException('Stack is empty!');
        }

        return array_shift($this->stack);
    }

    /**
     * @inheritdoc
     */
    public function top()
    {
        return current($this->stack);
    }

    /**
     * @inheritdoc
     */
    public function isEmpty()
    {
        return empty($this->stack);
    }
}
