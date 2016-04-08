<?php
namespace Curator;

use Mockery as M;

/**
 * @group Git
 */
class GitReaderTest extends \PHPUnit_Framework_TestCase
{
    public function testPassRevisionRangeToShell()
    {
        $args = ['revision range' => 'FROM..TO'];
        $cmd = "git log {$args['revision range']} --pretty=format:%s";
        $shell = M::mock('Curator\Shell');
        $gitReader = new GitReader($shell);

        $shell->shouldReceive('exec')->with('git fetch -u')->once();
        $shell->shouldReceive('exec')->with($cmd, [])->once();

        $gitReader->read($args);
    }
}
