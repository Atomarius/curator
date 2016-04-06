<?php
use Interop\Container\ContainerInterface;

return [
    'Application'       => function (ContainerInterface $c) {
        $app = new \Symfony\Component\Console\Application();
        $app->add(new \Curator\Application\MakeCommand($c));
        $app->add(new \Curator\Application\ApplyCommand());

        return $app;
    },
    'JiraLinkFormatter' => function (ContainerInterface $c) {
        $config = $c->get('JiraLinkFormatter.config');

        return new \Curator\FieldFormatter($config);
    },
    'GitReader'         => function (ContainerInterface $c) {
        return new \Curator\GitReader();
    },
    'ChangelogWriter'   => function (ContainerInterface $c) {
        return new \Curator\ChangelogWriter(
            $c->get('ChangelogWriter.config'),
            $c->get('GitReader'),
            $c->get('CommitFormatter')
        );
    },
    'CommitFormatter'   => function (ContainerInterface $c) {
        $processors = [];
        foreach ($c->get('CommitFormatter.processors') as $field => $processor) {
            $processors[$field] = $c->get($processor);
        }

        return new \Curator\CommitFormatter($c->get('CommitFormatter.config'), $processors);
    },
];
