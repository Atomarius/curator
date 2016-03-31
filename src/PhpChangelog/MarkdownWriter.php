<?php

namespace PhpChangelog;

class MarkdownWriter
{
    private $config;

    private $filename;

    /**
     * @param string $filename
     * @param array  $config
     */
    public function __construct($config, $filename)
    {
        $this->config = $config;
        $this->filename = $filename;
    }

    /**
     * @param array $content
     */
    public function write($content)
    {
        file_exists($this->filename) && unlink($this->filename);
        $content = $this->sortContent($content);
        foreach ($content as $group => $messages) {
            if (empty($messages)) {
                continue;
            }
            $title = isset($this->config[$this->config['sort-by']][$group]) ? $this->config[$this->config['sort-by']][$group] : $group;
            $data = str_replace("<{$this->config['sort-by']}>", $title, $this->config['list-header-template']);
            $data .= implode(PHP_EOL, $messages);
            file_put_contents($this->filename, $data, FILE_APPEND);
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
                foreach ($message as $key => $value) {
                    $entry = str_replace("<{$key}>", trim($value), $entry);
                }
                $sorted[$message[$this->config['sort-by']]][md5($entry)] = $entry;
            } else {
                $entry = str_replace('<default>', trim($message), $this->config['list-default-template']);
                $sorted['uncategorized'][md5($entry)] = $entry;
            }
        }

        return $sorted;
    }
}
