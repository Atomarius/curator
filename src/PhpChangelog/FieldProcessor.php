<?php

namespace PhpChangelog;

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
            foreach ($matches[0] as $match) {
                $replace = str_replace('<match>', $match, $this->replace);
                $value = str_replace($match, $replace, $value);
            }
        }

        return $value;
    }
}
