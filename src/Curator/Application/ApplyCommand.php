<?php

namespace Curator\Application;

use Interop\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ApplyCommand extends Command
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('apply')
            ->setDescription('Apply change to CHANGELOG.md');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->container;

        $source = $container->get('MarkdownWriter.config')['filename'];
        $target = 'CHANGELOG.md';
        if (!file_exists($source)) {
            $output->writeln("Source file {$source} does not exist");

            return 1;
        }

        if (!file_exists($target)) {
            $output->writeln("Target file {$target} does not exist");

            return 1;
        }

        $data = str_replace('{unreleased}', '{unreleased}' . file_get_contents($source), file_get_contents($target));
        file_put_contents($target, $data);
        unlink($source);

        $output->writeln("Changes from {$source} applied to {$target}");

        return 0;
    }
}
