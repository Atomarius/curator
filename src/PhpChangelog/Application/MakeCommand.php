<?php

namespace PhpChangelog\Application;

use Interop\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeCommand extends Command
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('make')
            ->setDescription('Make new changelog');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->container;

        $commitParser = $container->get('CommitParser');
        $commits = $container->get('GitReader')->read();
        $messages = [];
        foreach ($commits as $commit) {
            $messages[] = $commitParser->parse($commit);
        }

        $container->get('MarkdownWriter')->write($messages);
        $filename = $container->get('MarkdownWriter.config')['filename'];
        $output->writeln("Changelog generated {$filename}");

        return 0;
    }
}
