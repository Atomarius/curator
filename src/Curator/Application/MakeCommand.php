<?php

namespace Curator\Application;

use Curator\ChangelogWriter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MakeCommand extends Command
{
    use ContainerAware;

    protected function configure()
    {
        $this
            ->setName('make')
            ->setDescription('Make new changelog')
            ->addArgument(
                'filename',
                InputArgument::OPTIONAL,
                'Name of outputfile',
                'CHANGELOG_TMP'
            )
        ->addOption('from', null, InputOption::VALUE_REQUIRED)
        ->addOption('to', null, InputOption::VALUE_REQUIRED)
        ->addOption('lockfile', null, InputOption::VALUE_REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var ChangelogWriter $changelogWriter */
        $changelogWriter = $this->getContainer()->get('ChangelogWriter');
        $filename = $input->getArgument('filename');
        $changelogWriter->write($filename, $input->getOptions());
        $output->writeln("Changelog generated {$filename}");

        return 0;
    }
}
