<?php

namespace Curator;

class FieldProcessor
{
    /** @var string */
    private $pattern;
    /** @var string */
    private $replace;

    /**
     * @param string $pattern
     * @param string $replace
     */
    public function __construct($pattern, $replace)
    {
        $this->pattern = $pattern;
        preg_match_all('/<(\w*)>/', $this->pattern, $fields);
        $this->fields = $fields[1];
        $this->replace = $replace;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function process($value)
    {
        $matches = [];
        if (preg_match_all($this->pattern, $value, $matches)) {
            foreach ($this->fields as $field) {
                foreach ($matches[$field] as $match) {
                    $replace = str_replace("<{$field}>", $match, $this->replace);
                    $value = str_replace($match, $replace, $value);
                }
            }

        }

        return $value;
    }
}
