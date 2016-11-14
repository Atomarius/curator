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
            ->addArgument('revision range', InputArgument::OPTIONAL, 'Show only commits in the specified revision range')
            ->addOption('file', 'f', InputOption::VALUE_REQUIRED, 'Name of output file', 'CHANGELOG_TMP')
            ->addOption('version-file', null, InputOption::VALUE_REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var ChangelogWriter $changelogWriter */
        $changelogWriter = $this->getContainer()->get('ChangelogWriter');
        $filename = $input->getOption('file');
        $changelogWriter->write($filename, array_merge($input->getArguments(), $input->getOptions()));
        $output->writeln("Changelog generated {$filename}");

        return 0;
    }
}
