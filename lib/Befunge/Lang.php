<?php

namespace Befunge;

class Lang
{
    protected $source = null;
    protected $interpreter = null;


    protected function normaliseEol($string)
    {
        $string = str_replace('\r\n', '\n', $string);
        $string = str_replace('\r', '\n', $string);
        $string = preg_replace('/\n{2,}/', '\n', $string);

        return $string;
    }

    protected function createSource($string)
    {
        $source = explode("\n", $string);
        return $source;
    }

    public function __construct()
    {
        $this->interpreter = new Interpreter();
    }

    public function fromFile($fileName)
    {
        $this->fromString(file_get_contents($fileName));

    }

    public function fromString($string)
    {
        $this->source = $this->createSource($this->normaliseEol($string));
    }

    public function run()
    {
        $this->interpreter->setSource($this->source);
        if (is_null($this->source)) {
            throw new \Exception("No source set");
        } else {
            print(implode($this->interpreter->run()));
        }
    }

    public function reset()
    {
        $this->source = null;
    }


} 