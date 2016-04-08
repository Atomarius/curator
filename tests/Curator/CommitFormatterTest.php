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

class CommitFormatterTest extends \PHPUnit_Framework_TestCase
{
    /** @var CommitFormatter */
    private $fixture;

    public function setUp()
    {
        $config = [
            'pattern' => '/(?<type>\w+)\((?<scope>.+)\):\s(?<subject>.+)/',
            'replace' => '* **<scope>**: <subject>',
            'index' => 'type',
        ];
        $this->fixture = new CommitFormatter($config, []);
    }

    public function testParseReturnsArrayOnMatch()
    {
        $value = 'type(scope): subject';
        $expected = ['index' => 'type', 'message' => '* **scope**: subject'];
        $this->assertEquals($expected, $this->fixture->process($value));
    }

    public function testReturnsStringOnMismatch()
    {
        $value = 'message';
        $this->assertEquals(['index' => 'undefined', 'message' => $value], $this->fixture->process($value));
    }
}
