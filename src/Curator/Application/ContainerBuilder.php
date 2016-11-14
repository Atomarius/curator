<?php

/*
 * This file is part of Curator.
 *
 * (c) Marius Schütte <marius.schuette@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Curator\Application;

class ContainerBuilder
{
    /**
     * @param array $definitions
     *
     * @return \DI\Container
     */
    public static function build($definitions)
    {
        $builder = new \DI\ContainerBuilder();
        $builder->useAutowiring(false);
        $builder->useAnnotations(false);
        $builder->addDefinitions($definitions);

        return $builder->build();
    }
}
