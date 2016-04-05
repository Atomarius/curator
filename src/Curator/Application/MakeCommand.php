<?php

namespace Curator\Application;

use Curator\ChangelogWriter;
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
        /** @var ChangelogWriter $changelogWriter */
        $changelogWriter = $this->container->get('ChangelogWriter');
        $filename = 'CHANGELOG_TMP.md';

        $changelogWriter->write($filename);
        $output->writeln("Changelog generated {$filename}");

        return 0;
    }
}
