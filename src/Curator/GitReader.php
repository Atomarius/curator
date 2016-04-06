<?php

namespace Curator;

class GitReader
{
    public function read($options = [])
    {
        $options = $this->processOptions($options);

        $command = "git log {$options['range']} --pretty=format:%s";

        exec($command, $output);

        return $output;
    }

    private function processOptions($opts)
    {
        $opts['from'] = isset($opts['from']) ? $opts['from'] : '';
        $opts['to'] = isset($opts['to']) ? $opts['to'] : 'HEAD';
        $opts['from'] = isset($opts['lockfile']) ? file_get_contents($opts['lockfile']) : $opts['from'];
        $opts['range'] = !empty($opts['from']) ? implode('..', [$opts['from'], $opts['to']]) : $opts['to'];

        return $opts;
    }
}
