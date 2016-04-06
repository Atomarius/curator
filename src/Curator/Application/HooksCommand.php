<?php

namespace Curator\Application;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HooksCommand extends Command
{
    use ContainerAware;

    protected function configure()
    {
        $this
            ->setName('hooks')
            ->setDescription('Manage hooks')
            ->addArgument(
                'action',
                InputArgument::REQUIRED,
                'install|remove'
            )
            ->addArgument(
                'hook',
                InputArgument::REQUIRED
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $hook = $input->getArgument('hook');
        if ($input->getArgument('action') == 'install') {
            if (!file_exists("hooks/{$hook}")) {
                $output->writeln("hooks/{$hook} does not exist");

                return 1;
            }
            file_exists(".git/hooks/{$hook}") || symlink("../../hooks/{$hook}", ".git/hooks/{$hook}");
        } elseif ($input->getArgument('action') == 'remove') {
            file_exists(".git/hooks/{$hook}") && unlink(".git/hooks/{$hook}");
        } elseif ($input->getArgument('action') == 'copy') {
            $approot = $this->getContainer()->get('curator.root');
            if (!file_exists("{$approot}/hooks/{$hook}")) {
                $output->writeln("{$approot}/hooks/{$hook} does not exist");

                return 1;
            }
            if (file_exists("hooks/{$hook}")) {
                $output->writeln("hooks/{$hook} already exists");

                return 1;
            }
            is_dir('hooks') || mkdir('hooks', 0777, true);
            copy("{$approot}/hooks/{$hook}", "hooks/{$hook}");
        }

        return 0;
    }
}
