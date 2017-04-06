<?php
/**
 * Created by PhpStorm.
 * User: Donii Sergii
 * Date: 4/6/17
 * Time: 3:59 PM
 */

namespace sonrac\relations;

/**
 * Interface IStack
 * Define structure for relation trait
 *
 * @package sonrac\relations
 */
interface IStack
{

    /**
     * IStack constructor.
     *
     * @param null|int $limit Limit items in list
     */
    public function __construct($limit = null);

    /**
     * Add new item into structure
     *
     * @param mixed $item New stack item
     */
    public function push(&$item);

    /**
     * Pop item from structure
     *
     * @return mixed
     */
    public function pop();

    /**
     * Get top element from structure
     *
     * @return mixed
     */
    public function top();

    /**
     * Check structure empty
     *
     * @return bool
     */
    public function isEmpty();
}