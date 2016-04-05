<?php

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
