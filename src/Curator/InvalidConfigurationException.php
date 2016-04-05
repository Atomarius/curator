<?php

namespace Curator;

class InvalidConfigurationException extends \RuntimeException
{
    const MSG = 'Parameter %s missing';

    public static function create($field)
    {
        return new self(sprintf(self::MSG, $field));
    }
}
