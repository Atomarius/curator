<?php

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
