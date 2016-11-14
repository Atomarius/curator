<?php

namespace Curator;

use Mockery as M;

class GitReaderTest extends \PHPUnit_Framework_TestCase
{
    private $output = <<<EOL
misc(CommitFormatterTest): Style
---<EOM>---
misc(composer.json): Updated dependencies

Moved mockery/mockery to require-dev
Updated symfony/console to ^2.5
---<EOM>---
EOL;

    public function testPassRevisionRangeToShell()
    {
        $expected = [
            'misc(CommitFormatterTest): Style',
            'misc(composer.json): Updated dependencies

Moved mockery/mockery to require-dev
Updated symfony/console to ^2.5'
        ];

        /** @var \Curator\Shell|M\MockInterface $shell */
        $shell = M::mock('Curator\Shell');
        $gitReader = new GitReader($shell);
        $args = ['revision range' => 'FROM..TO'];
        $shell->shouldReceive('shell_exec')->andReturn($this->output);

        $this->assertEquals($expected, $gitReader->read($args));
    }
}
