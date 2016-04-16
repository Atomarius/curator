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

class GitReader
{
    /** @var Shell */
    private $shell;

    /**
     * GitReader constructor.
     *
     * @param Shell $shell
     */
    public function __construct($shell, $options=[])
    {
        $this->format = isset($options['format']) ? isset($options['format']) : '%s';
        $this->shell = $shell;
    }

    /**
     * @param array $args
     *
     * @return array
     */
    public function read($args = [])
    {
        $args = $this->processOptions($args);

        $this->shell->exec('git fetch -u');

        $command = "git log {$args['revision range']} --pretty=format:\"%B%h---<EOM>---\"";
        $output = $this->shell->shell_exec($command);
        $output = explode("---<EOM>---\n", $output);

        var_dump($output);
        die();
        return $output;
    }

    private function processOptions($opts)
    {
        $opts['from'] = isset($opts['from']) ? $opts['from'] : '';
        $opts['to'] = isset($opts['to']) ? $opts['to'] : 'HEAD';
        $opts['from'] = isset($opts['version-file']) ? trim(file_get_contents($opts['version-file'])) : $opts['from'];
        $opts['revision range'] = !empty($opts['from']) ? implode('..', [$opts['from'], $opts['to']]) : $opts['revision range'];

        return $opts;
    }
}
