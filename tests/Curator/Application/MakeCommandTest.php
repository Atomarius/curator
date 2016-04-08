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

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Mockery as M;

/**
 * @group Commands
 */
class MakeCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $args = ['command' => 'make', 'revision range' => 'FROM..TO'];
        $writer = M::mock('Curator\ChangelogWriter');
        $writer->shouldReceive('write')->with('CHANGELOG_TMP', $args);
        $def = ['ChangelogWriter' => $writer];
        $cont = ContainerBuilder::build($def);

        $application = new Application();
        $application->add((new MakeCommand())->setContainer($cont));
        $command = $application->find('make');
        $commandTester = new CommandTester($command);
        $commandTester->execute($args);
    }
}
