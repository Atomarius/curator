<?php

namespace PhpChangelog;

class CommitParser
{
    private $pattern;
    private $fields = [];

    /**
     * @param string $pattern
     */
    public function __construct($pattern)
    {
        $this->pattern = $pattern;
        preg_match_all('/<(\w*)>/', $this->pattern, $fields);
        $this->fields = $fields[1];
    }

    public function parse($commit)
    {
        $message = [];
        if (preg_match($this->pattern, $commit, $matches)) {
            foreach ($this->fields as $field) {
                $message[$field] = $matches[$field];
            }
        } else {
            $message = $commit;
        }

        return $message;
    }
}
