<?php

namespace PhpChangelog;

class FieldProcessor
{
    private $pattern;
    private $replace;

    /**
     * FieldProcessor constructor.
     */
    public function __construct()
    {
        $this->pattern = '/[A-Z]+\-\d+/';
        $this->replace = '[<match>](http://jira.goodgamestudios.com/browse/<match>)';
    }

    public function process($value)
    {
        $matches = [];
        if (preg_match_all($this->pattern, $value, $matches)) {
           foreach ($matches[0] as $match) {
               $replace = str_replace('<match>', $match, $this->replace);
               $value = str_replace($match, $replace, $value);
           }
        }

        return $value;
    }
}