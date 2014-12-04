<?php

namespace Befunge;

/**
 * Class Lang
 * @package Befunge
 */
class Lang
{
    /**
     * @var array|null
     */
    protected $source = null;
    /**
     * @var Interpreter|null
     */
    protected $interpreter = null;


    /**
     * @param $string
     *
     * @return mixed
     */
    protected function normaliseEol($string)
    {
        $string = str_replace('\r\n', '\n', $string);
        $string = str_replace('\r', '\n', $string);
        $string = preg_replace('/\n{2,}/', '\n', $string);

        return $string;
    }

    /**
     * @param $string
     *
     * @return array
     */
    protected function createSource($string)
    {
        $source = explode("\n", $string);
        return $source;
    }

    /**
     *
     */
    public function __construct()
    {
        $this->interpreter = new Interpreter();
    }

    /**
     * @param $fileName
     */
    public function fromFile($fileName)
    {
        $this->fromString(file_get_contents($fileName));

    }

    /**
     * @param $string
     */
    public function fromString($string)
    {
        $this->source = $this->createSource($this->normaliseEol($string));
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function run()
    {
        $this->interpreter->setSource($this->source);
        if (is_null($this->source)) {
            throw new \Exception("No source set");
        } else {
            return implode($this->interpreter->run());
        }
    }

    /**
     *
     */
    public function reset()
    {
        $this->source = null;
    }


} 