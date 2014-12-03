<?php

namespace Befunge;

class Interpreter
{
    protected $up = array(0, -1);
    protected $down = array(0, 1);
    protected $left = array(-1, 0);
    protected $right = array(1, 0);
    protected $directions;
    protected $currentDirection = null;
    protected $finished = false;
    protected $asciiMode = false;
    protected $x = 0;
    protected $y = 0;
    protected $output = array();
    /* @var Stack */
    protected $stack;
    protected $source;
    protected $runningSource;


    public function __construct()
    {
        $this->directions = array($this->up, $this->down, $this->left, $this->right);
    }

    public function setSource($source)
    {
        $this->source = $source;
    }

    public function run()
    {
        $this->stack = new Stack();
        $this->output = array();
        $this->x = 0;
        $this->y = 0;
        $this->runningSource = $this->source;
        $this->finished = false;
        $this->asciiMode = false;
        $this->currentDirection = null;
        while (!$this->finished) {
            $cell = $this->runningSource[$this->y][$this->x];
            if ($cell === '"') {
                $this->asciiMode = !$this->asciiMode;
            }
            if ($this->asciiMode) {
                $this->stack->push(ord($cell));
            } else {
                $this->cmd($cell);
            }
            if (is_null($this->currentDirection)) {
                throw new \Exception("First command should set the direction");
            } else {
                $this->move();
            }
        }

        return $this->output;
    }

    protected function move()
    {
        $this->x += $this->currentDirection[0];
        if ($this->x < 0) {
            $this->x = strlen($this->source[$this->y]) - 1;
        } else if ($this->x == strlen($this->source[$this->y])) {
            $this->x = 0;
        }
        $this->y += $this->currentDirection[1];
        if ($this->y < 0) {
            $this->y = count($this->source) - 1;
        } else if ($this->y == count($this->source)) {
            $this->y = 0;
        }
    }

    protected function cmd($cell)
    {
        //0..9 - Push this digit on the stack
        if (ord($cell) >= ord('0') && ord($cell) <= ord('9')) {
            $this->stack->push((int)$cell);
        }
        switch ($cell) {
            //start moving right
            case '>':
                $this->currentDirection = $this->right;
                break;

            //start moving left
            case '<':
                $this->currentDirection = $this->left;
                break;

            //start moving up
            case '^':
                $this->currentDirection = $this->up;
                break;

            //start moving down
            case 'v':
                $this->currentDirection = $this->down;
                break;

            //start moving in a random cardinal direction
            case '?':
                $this->currentDirection = $this->directions[rand(0, 3)];
                break;

            //end program
            case '@':
                $this->finished = true;
                break;

            //space - NOP
            case chr(32):
                break;

            //skip next cell
            case '#':
                $this->move();
                break;

            //addition
            case '+':
                $this->stack->push($this->stack->pop() + $this->stack->pop());
                break;

            //subtraction
            case '-':
                $a = $this->stack->pop();
                $b = $this->stack->pop();
                $this->stack->push($b - $a);
                break;

            //multiplication
            case '*':
                $this->stack->push($this->stack->pop() * $this->stack->pop());
                break;
            //integer division
            case '/':
                $a = $this->stack->pop();
                $b = $this->stack->pop();
                $this->stack->push(floor($b / $a));
                break;

            //modulo
            case '%':
                $a = $this->stack->pop();
                $b = $this->stack->pop();
                $this->stack->push($b % $a);
                break;

            //logical not
            case '!':
                $a = $this->stack->pop();
                $this->stack->push($a == 0 ? 1 : 0);
                break;

            //greater than
            case '`':
                $a = $this->stack->pop();
                $b = $this->stack->pop();
                $this->stack->push($b > $a ? 1 : 0);
                break;

            //if value == 0 then move right otherwise move left
            case '_':
                $this->currentDirection = $this->stack->pop() == 0 ? $this->right : $this->left;
                break;

            //if value == 0 then move down otherwise move up
            case '|':
                $this->currentDirection = $this->stack->pop() == 0 ? $this->down : $this->up;
                break;

            //duplicate top stack value
            case ':':
                $a = $this->stack->pop();
                $this->stack->push($a);
                $this->stack->push($a);
                break;

            //swap top two stack values
            case '\\':
                $a = $this->stack->pop();
                $b = $this->stack->pop();
                $this->stack->push($a);
                $this->stack->push($b);
                break;

            //discard top stack value
            case '$':
                $this->stack->pop();
                break;

            //pop value and output as an integer
            case '.':
                $this->output[] = strval($this->stack->pop());
                break;

            //Pop value and output as ASCII character
            case ',':
                $this->output[] = chr($this->stack->pop());
                break;

            //put value into cell
            case 'p':
                $y = $this->stack->pop();
                $x = $this->stack->pop();
                $value = $this->stack->pop();
                $this->runningSource[$y][$x] = $value;
                break;

            //get value from cell
            case 'g':
                $y = $this->stack->pop();
                $x = $this->stack->pop();
                $this->stack->push($this->runningSource[$y][$x]);
                break;
        }
    }
} 