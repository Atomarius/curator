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

class Shell
{
    public function exec($command, array &$output = null, &$return_var = null)
    {
        return exec($command, $output, $return_var);
    }

    public function shell_exec($command)
    {
        return shell_exec($command);
    }
}
