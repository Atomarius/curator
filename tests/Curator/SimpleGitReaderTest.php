<?php

/*
 * This file is part of Curator.
 *
 * (c) Marius Schütte <marius.schuette@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Curator;

use Mockery as M;

/**
 * @group Git
 */
class SimpleGitReaderTest extends \PHPUnit_Framework_TestCase
{
    public function testPassRevisionRangeToShell()
    {
        $args = ['revision range' => 'FROM..TO'];
        $cmd = "git log {$args['revision range']} --pretty=format:%s";
        $shell = M::mock('Curator\Shell');
        $gitReader = new SimpleGitReader($shell);

        $shell->shouldReceive('exec')->with('git fetch -u')->once();
        $shell->shouldReceive('exec')->with($cmd, [])->once();

        $gitReader->read($args);
    }
}
