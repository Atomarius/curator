<?php
use Interop\Container\ContainerInterface;

return [
    'Application' => function (ContainerInterface $c) {
        $app = new \Symfony\Component\Console\Application();
        $app->add(new \Curator\Application\MakeCommand($c));
        $app->add(new \Curator\Application\ApplyCommand($c));

        return $app;
    },
    'JiraLinkProcessor'         => function (ContainerInterface $c) {
        $pattern = $c->get('JiraLinkProcessor.pattern');
        $replace = $c->get('JiraLinkProcessor.replace');
        return new \Curator\FieldProcessor($pattern, $replace);
    },
    'GitReader'             => function (ContainerInterface $c) {
        return new \Curator\GitReader();
    },
    'MarkdownWriter'        => function (ContainerInterface $c) {
        $fieldProcessors = [];
        foreach ($c->get('MarkdownWriter.processors') as $field => $processor) {
            $fieldProcessors[$field] = $c->get($processor);
        }
        return new \Curator\MarkdownWriter($c->get('MarkdownWriter.config'), $fieldProcessors);
    },
    'CommitParser'          => function (ContainerInterface $c) {
        return new \Curator\CommitParser($c->get('CommitParser.pattern'));
    },
];
