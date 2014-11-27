<?php
/**
 * Created by PhpStorm.
 * User: wt
 * Date: 27.11.14
 * Time: 22:06
 */

namespace Befunge;


class Interpreter
{

    protected $stack;

    public function __construct()
    {
        $this->stack = new Stack();
    }
} 