<?php

namespace Curator;

class GitReader
{
    public function read($options = [])
    {
        $options = $this->processOptions($options);

        exec('git fetch -u');
        exec("git log {$options['revision range']} --pretty=format:%s", $output);

        return $output;
    }

    private function processOptions($opts)
    {
        $opts['from'] = isset($opts['from']) ? $opts['from'] : '';
        $opts['to'] = isset($opts['to']) ? $opts['to'] : 'HEAD';
        $opts['from'] = isset($opts['lockfile']) ? trim(file_get_contents($opts['lockfile'])) : $opts['from'];
        $opts['revision range'] = !empty($opts['from']) ? implode('..', [$opts['from'], $opts['to']]) : $opts['to'];

        return $opts;
    }
}
