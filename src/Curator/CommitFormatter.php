<?php

namespace Curator;

class CommitFormatter
{
    /** @var string */
    private $pattern;
    /** @var string */
    private $replace;
    /** @var array */
    private $fields = [];
    private $index;
    private $processors;

    /**
     * @param array $config
     */
    public function __construct($config, $processors)
    {
        $this->assertConfigIsValid($config);
        $this->pattern = $config['pattern'];
        preg_match_all('/<(\w+)>/', $this->pattern, $fields);
        $this->fields = $fields[1];
        $this->replace = $config['replace'];
        $this->index = $config['index'];
        $this->processors = $processors;
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
                $replace = $this->applyProcessor($field, $matches[$field]);
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
    private function applyProcessor($field, $value)
    {
        if (isset($this->fieldProcessors[$field])) {
            /** @var $processor \Curator\FieldFormatter */
            $processor = $this->fieldProcessors[$field];

            return $processor->process($value);
        }
        return $value;
    }
}
