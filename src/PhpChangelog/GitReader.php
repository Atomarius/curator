<?php

namespace PhpChangelog;

class GitReader
{
    public function read($options = [])
    {
        $options['from'] = isset($options['from']) ? $options['from'] : '';
        $options['to'] = isset($options['to']) ? $options['to'] : 'HEAD';

        $command = 'git log --pretty=format:%s ';
        $command .= !empty($options['from']) ? implode('..', [$options['from'], $options['to']]) : $options['to'];

        exec($command, $output);

        return $output;
    }
}
