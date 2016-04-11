<?php

namespace Curator\FieldFormatter;

class SearchAndReplaceFormatter implements FieldFormatter
{
    /** @var array */
    private $replace = [];

    /**
     * @param array $replace
     */
    public function __construct($replace)
    {
        $this->replace = $replace;
    }

    public function process($value)
    {
        return str_replace(array_keys($this->replace), $this->replace, $value);
    }
}
