<?php
use Interop\Container\ContainerInterface;

return [
    'Application' => function (ContainerInterface $c) {
        $app = new \Symfony\Component\Console\Application();
        $app->add(new \PhpChangelog\Application\MakeCommand($c));
        $app->add(new \PhpChangelog\Application\ApplyCommand($c));

        return $app;
    },
    'JiraLinkProcessor'         => function (ContainerInterface $c) {
        $pattern = $c->get('JiraLinkProcessor.pattern');
        $replace = $c->get('JiraLinkProcessor.replace');
        return new \PhpChangelog\FieldProcessor($pattern, $replace);
    },
    'GitReader'             => function (ContainerInterface $c) {
        return new \PhpChangelog\GitReader();
    },
    'MarkdownWriter'        => function (ContainerInterface $c) {
        $fieldProcessors = [];
        foreach ($c->get('MarkdownWriter.processors') as $field => $processor) {
            $fieldProcessors[$field] = $c->get($processor);
        }
        return new \PhpChangelog\MarkdownWriter($c->get('MarkdownWriter.config'), $fieldProcessors);
    },
    'CommitParser'          => function (ContainerInterface $c) {
        return new \PhpChangelog\CommitParser($c->get('CommitParser.pattern'));
    },
];
