<?php

namespace Curator\Application;

use Curator\ChangelogWriter;
use Interop\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
        $this
            ->setName('make')
            ->setDescription('Make new changelog')
            ->addArgument(
                'filename',
                InputArgument::OPTIONAL,
                'Name of outputfile',
                'CHANGELOG_TMP.md'
            );
//        ->addOption('from', null, InputOption::VALUE_REQUIRED)
//        ->addOption('to', null, InputOption::VALUE_REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var ChangelogWriter $changelogWriter */
        $changelogWriter = $this->container->get('ChangelogWriter');
        $filename = $input->getArgument('filename');
        $changelogWriter->write($filename);
        $output->writeln("Changelog generated {$filename}");

        return 0;
    }
}
