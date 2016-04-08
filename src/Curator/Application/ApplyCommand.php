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

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ApplyCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('apply')
            ->setDescription('Apply change to CHANGELOG.md')
            ->addArgument(
                'source',
                InputArgument::REQUIRED,
                'Name of inputfile'
            )
            ->addArgument(
                'target',
                InputArgument::OPTIONAL,
                'Name of outputfile',
                'CHANGELOG.md'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $source = $input->getArgument('source');
        $target = $input->getArgument('target');

        if (!file_exists($source)) {
            $output->writeln("Source file {$source} does not exist");

            return 1;
        }

        if (!file_exists($target)) {
            $output->writeln("Target file {$target} does not exist");

            return 1;
        }

        $replace = '{unreleased}' . file_get_contents($source);
        $data = str_replace('{unreleased}', $replace, file_get_contents($target));
        file_put_contents($target, $data);
        unlink($source);

        $output->writeln("Changes from {$source} applied to {$target}");

        return 0;
    }
}
