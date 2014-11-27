<?php
/**
 * Created by PhpStorm.
 * User: wt
 * Date: 27.11.14
 * Time: 22:07
 */

namespace Befunge;


/**
 * Class Stack
 * @package Befunge
 */
class Stack
{
    /**
     * @var array
     */
    protected $stack;

    /**
     *
     */
    public function __construct()
    {
        $this->stack = array();
    }

    /**
     * @returns mixed
     * @throws \Exception
     */
    public function pop()
    {
        if (count($this->stack) > 0) {
            return array_pop($this->stack);
        } else {
            throw new \Exception("Stack is empty");
        }
    }

    /**
     * @param $value
     */
    public function push($value)
    {
        $this->stack[] = $value;
    }
} 