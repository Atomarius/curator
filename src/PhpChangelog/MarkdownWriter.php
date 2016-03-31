<?php

namespace PhpChangelog;

class MarkdownWriter
{
    private $config;
    private $filename;

    /**
     * @param string $filename
     * @param array $config
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
        $type_template = PHP_EOL . PHP_EOL . '### %s';
        $template = PHP_EOL . '* **%s**: %s';
        file_exists($this->filename) && unlink($this->filename);
        foreach (array_keys($this->config[$this->config['sort-by']]) as $type) {
            $data = sprintf($type_template, $this->config[$this->config['sort-by']][$type]);
            file_put_contents($this->filename, $data, FILE_APPEND);
            foreach ($content as $message) {
                if (is_array($message) && isset($message[$this->config['sort-by']]) && $message[$this->config['sort-by']] == $type) {
                    $data = sprintf($template, trim($message['scope']), trim($message['message']));
                    file_put_contents($this->filename, $data, FILE_APPEND);
                }
            }
        }

        if (!empty($uncategorized)) {
            $data = sprintf($type_template, 'Uncategorized');
            file_put_contents($this->filename, $data, FILE_APPEND);
            foreach ($uncategorized as $message) {
                if (is_string($message)) {
                    $data = sprintf($template, 'none', trim($message));
                    file_put_contents($this->filename, $data, FILE_APPEND);
                }
            }
        }
    }
}
