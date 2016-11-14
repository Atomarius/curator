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

class SimpleGitReader
{
    /** @var Shell */
    private $shell;

    /**
     * GitReader constructor.
     *
     * @param Shell $shell
     */
    public function __construct($shell)
    {
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
        $this->shell->exec("git log {$args['revision range']} --pretty=format:%s", $output);

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
