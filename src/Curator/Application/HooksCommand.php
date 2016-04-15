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
                'list|install|remove'
            )
            ->addArgument(
                'hook',
                InputArgument::OPTIONAL,
                null
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $hook = $input->getArgument('hook');

        switch ($input->getArgument('action')) {
            case 'install':
                $hook == '' || $this->install($output, $hook);
                break;
            case 'remove':
                $hook == '' || $this->remove($hook);
                break;
            default:
                foreach (glob($this->cwdir('*')) as $hook) {
                    $output->writeln($hook);
                }
        }

        return 0;
    }

    /**
     * @param OutputInterface $output
     * @param string          $hook
     *
     * @return int
     */
    private function install(OutputInterface $output, $hook)
    {
        if (!file_exists($this->cwdir($hook))) {
            is_dir('hooks') || mkdir('hooks', 0777, true);
            if (!file_exists($this->appdir($hook))) {
                $output->writeln("{$this->appdir($hook)} does not exist");

                return 0;
            }
            copy($this->appdir($hook), $this->cwdir($hook));
        }
        file_exists($this->gitdir($hook)) || symlink("../../hooks/{$hook}", $this->gitdir($hook));

        return 0;
    }

    /**
     * @param string $hook
     *
     * @return bool
     */
    private function remove($hook)
    {
        return file_exists($this->gitdir($hook)) && unlink($this->gitdir($hook));
    }

    private function appdir($hook)
    {
        return "{$this->getContainer()->get('curator.root')}/hooks/{$hook}";
    }
    
    private function cwdir($hook)
    {
        return "hooks/{$hook}";
    }

    private function gitdir($hook)
    {
        return ".git/hooks/{$hook}";
    }
}
