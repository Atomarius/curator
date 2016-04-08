<?php

/*
 * This file is part of Curator.
 *
 * (c) Marius Schütte <marius.schuette@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Curator;

class CommitFormatter
{
    /** @var string */
    private $pattern;
    /** @var string */
    private $replace;
    /** @var array */
    private $fields = [];
    /** @var string */
    private $index;
    /** @var array */
    private $formatters = [];

    /**
     * @param array $config
     * @param array $formatters
     */
    public function __construct($config, $formatters)
    {
        $this->assertConfigIsValid($config);
        $this->pattern = $config['pattern'];
        preg_match_all('/<(\w+)>/', $this->pattern, $fields);
        $this->fields = $fields[1];
        $this->replace = $config['replace'];
        $this->index = $config['index'];
        $this->formatters = $formatters;
    }

    private function assertConfigIsValid($config)
    {
        $required = ['pattern', 'replace', 'index'];
        foreach ($required as $field) {
            if (!isset($config[$field])) {
                throw InvalidConfigurationException::create($field);
            }
        }
    }

    /**
     * @param string $commit
     *
     * @return array
     */
    public function process($commit)
    {
        $matches = $message = [];
        if (preg_match($this->pattern, $commit, $matches)) {
            $commit = $this->replace;
            foreach ($this->fields as $field) {
                $replace = $this->format($field, $matches[$field]);
                $commit = str_replace("<{$field}>", $replace, $commit);
            }
            $message = ['index' => $matches[$this->index], 'message' => $commit];
        } else {
            $message = ['index' => 'undefined', 'message' => $commit] ;
        }
        return $message;
    }

    /**
     * @param string $field
     * @param string $value
     *
     * @return string
     */
    private function format($field, $value)
    {
        if (isset($this->formatters[$field])) {
            /** @var $formatter \Curator\FieldFormatter */
            $formatter = $this->formatters[$field];

            return $formatter->process($value);
        }
        return $value;
    }
}
