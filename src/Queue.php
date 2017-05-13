<?php
/**
 * Created by PhpStorm.
 * User: Donii Sergii
 * Date: 4/6/17
 * Time: 12:29 PM
 */

namespace sonrac\relations;

/**
 * Class Queue
 * Queue for relation models
 *
 * @package sonrac\relations
 */
class Queue extends Stack
{
    /**
     * Stack
     *
     * @var array
     */
    protected $queue;

    /**
     * Stack constructor.
     *
     * @param int $limit Limit stack elements
     */
    public function __construct($limit = null)
    {
        $this->limit = $limit;
        $this->queue = [];
    }

    /**
     * Add new item into queue
     *
     * @param mixed $item New stack item
     */
    public function push(&$item)
    {
        if (is_null($this->limit) || (count($this->queue) < $this->limit)) {

            array_push($this->queue, $item);

            return;
        }

        throw new \RunTimeException('Stack is full!');
    }

    /**
     * Pop item from queue
     *
     * @return mixed
     */
    public function pop()
    {
        if ($this->isEmpty()) {
            throw new \RunTimeException('Stack is empty!');
        }

        return array_pop($this->queue);
    }
}
