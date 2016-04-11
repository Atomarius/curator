<?php
use Interop\Container\ContainerInterface;

return [
    'Application'       => function (ContainerInterface $c) {
        $app = new \Symfony\Component\Console\Application();
        $app->add((new \Curator\Application\MakeCommand())->setContainer($c));
        $app->add(new \Curator\Application\ApplyCommand());
        $app->add((new \Curator\Application\HooksCommand())->setContainer($c));

        return $app;
    },
    'JiraLinkFormatter' => function (ContainerInterface $c) {
        $config = $c->get('JiraLinkFormatter.config');

        return new \Curator\FieldFormatter\RegexFormatter($config);
    },
    'TypeFormatter' => function (ContainerInterface $c) {
        $config = $c->get('TypeFormatter.config');

        return new \Curator\FieldFormatter\SearchAndReplaceFormatter($config);
    },
    'GitReader'         => function (ContainerInterface $c) {
        return new \Curator\SimpleGitReader(new \Curator\Shell());
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
    'curator.root' => dirname(__DIR__),
];
