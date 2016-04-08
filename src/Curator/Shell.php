<?php

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
