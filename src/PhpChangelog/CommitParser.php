<?php

namespace PhpChangelog;

class CommitParser
{
    private $pattern;
    private $fields = [];

    /**
     * @param $pattern
     */
    public function __construct($pattern)
    {
        $this->pattern = $pattern;
        preg_match('/<(\w*)>/', $pattern, $this->fields);
    }

    public function parse($commit)
    {
        $message = [];
        if (preg_match($this->pattern, $commit, $matches)) {
            foreach ($this->fields as $field) {
                $message[$field] = $matches[$field];
            }
        }

        return $message;
    }
}
