<?php

namespace Curator;

class SimpleGitReader
{
    /** @var Shell */
    private $shell;

    /**
     * GitReader constructor.
     *
     * @param $shell
     */
    public function __construct($shell)
    {
        $this->shell = $shell;
    }

    public function read($args = [])
    {
        $args = $this->processOptions($args);

        $this->shell->exec('git fetch -u');
        $this->shell->exec("git log {$args['revision range']} --pretty=format:%s", $output);

        return $output;
    }

    private function processOptions($opts)
    {
        $opts['from'] = isset($opts['from']) ? $opts['from'] : '';
        $opts['to'] = isset($opts['to']) ? $opts['to'] : 'HEAD';
        $opts['from'] = isset($opts['lockfile']) ? trim(file_get_contents($opts['lockfile'])) : $opts['from'];
        $opts['revision range'] = !empty($opts['from']) ? implode('..', [$opts['from'], $opts['to']]) : $opts['revision range'];

        return $opts;
    }
}
