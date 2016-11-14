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

class ChangelogWriter
{
    private $config;
    /** @var SimpleGitReader repoReader */
    private $repoReader;
    /** @var CommitFormatter */
    private $commitFormatter;
    
    /**
     * @param array           $config
     * @param CommitFormatter $commitFormatter
     * @param SimpleGitReader $repoReader
     */
    public function __construct($config, $repoReader, $commitFormatter)
    {
        $this->config = $config;

        $this->commitFormatter = $commitFormatter;

        $this->repoReader = $repoReader;
    }

    /**
     * @param string $filename
     * @param array  $args
     */
    public function write($filename, $args = [])
    {
        file_exists($filename) && unlink($filename);
        $content = $this->sortContent($this->repoReader->read($args));
        foreach ($content as $group => $messages) {
            if (empty($messages)) {
                continue;
            }
            $title = isset($this->config['index'][$group]) ? $this->config['index'][$group] : $group;
            $data = str_replace("<index>", $title, $this->config['replace']);
            $data .= implode(PHP_EOL, $messages);
            file_put_contents($filename, $data, FILE_APPEND);
        }
    }

    private function sortContent($content)
    {
        $sorted = [];
        foreach (array_keys($this->config['index']) as $group) {
            $sorted[$group] = [];
        }
        foreach ($content as $message) {
            $message = $this->commitFormatter->process($message);
            $sorted[$message['index']][md5($message['message'])] = $message['message'];
        }

        return $sorted;
    }
}
