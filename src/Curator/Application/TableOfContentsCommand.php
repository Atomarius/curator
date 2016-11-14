<?php

namespace Curator\Application;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TableOfContentsCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('table-of-contents')
            ->setDescription('Create table of contents')
            ->addArgument(
                'filename',
                InputArgument::REQUIRED,
                'Name of inputfile'
            )
            ->addArgument(
                'depth',
                InputArgument::OPTIONAL,
                'Depth of indexing',
                2
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getArgument('filename');
        $depth = $input->getArgument('depth');


        if (!file_exists($filename)) {
            $output->writeln("Source file {$filename} does not exist");

            return 1;
        }

        $topics = [];
        $handle = fopen($filename, 'r');
        while ($line = fgets($handle)) {
            if (stripos($line, '#') > 0) {
                continue;
            }
            $hashes = substr_count($line, '#');
            if ($hashes == 1) {
                $topics[] = $line;
            }
            if ($hashes > 1 && $hashes < $depth + 1) {
                $topic = trim(str_replace('#', '', $line));
                $indent = str_repeat(' ', 4 * ($hashes - 2));
                $topics[] = "{$indent}- [{$topic}](#" . str_replace(' ', '-', strtolower($topic)) . ")";
            }
        }

        $content = file_get_contents($filename);
        foreach ($topics as $topic) {
            $content = str_replace($topic . PHP_EOL, '', $content);
        }
        file_put_contents($filename, implode(PHP_EOL, $topics) . PHP_EOL . $content);

        return 0;
    }
}
