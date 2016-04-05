<?php

namespace PhpChangelog;

class MarkdownWriter
{
    private $config;

    private $fieldProcessors;

    /**
     * @param string $fieldProcessors
     * @param array  $config
     */
    public function __construct($config, $fieldProcessors)
    {
        $this->config = $config;
        $this->fieldProcessors = $fieldProcessors;
    }

    /**
     * @param array $content
     */
    public function write($content)
    {
        file_exists($this->config['filename']) && unlink($this->config['filename']);
        $content = $this->sortContent($content);
        foreach ($content as $group => $messages) {
            if (empty($messages)) {
                continue;
            }
            $title = isset($this->config[$this->config['sort-by']][$group]) ? $this->config[$this->config['sort-by']][$group] : $group;
            $data = str_replace("<{$this->config['sort-by']}>", $title, $this->config['list-header-template']);
            $data .= implode(PHP_EOL, $messages);
            file_put_contents($this->config['filename'], $data, FILE_APPEND);
        }
    }

    private function sortContent($content)
    {
        $sorted = [];
        foreach (array_keys($this->config[$this->config['sort-by']]) as $group) {
            $sorted[$group] = [];
        }

        foreach ($content as $message) {
            if (is_array($message) && isset($message[$this->config['sort-by']])) {
                $entry = $this->config['list-entry-template'];
                foreach ($message as $field => $value) {
                    $value = $this->applyProcessor($field, $value);
                    $entry = str_replace("<{$field}>", trim($value), $entry);
                }
                $sorted[$message[$this->config['sort-by']]][md5($entry)] = $entry;
            } else {
                $entry = str_replace('<default>', trim($message), $this->config['list-default-template']);
                $sorted['uncategorized'][md5($entry)] = $entry;
            }
        }

        return $sorted;
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
            /** @var $processor \PhpChangelog\FieldProcessor */
            $processor = $this->fieldProcessors[$field];

            return $processor->process($value);
        }
        return $value;
    }
}
