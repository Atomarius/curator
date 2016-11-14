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

class InvalidConfigurationException extends \RuntimeException
{
    const MSG = 'Parameter %s missing';

    public static function create($field)
    {
        return new self(sprintf(self::MSG, $field));
    }
}
