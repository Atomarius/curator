<?php

namespace PhpChangelog;

class CommitParserTest extends \PHPUnit_Framework_TestCase
{
    /** @var CommitParser */
    private $fixture;

    public function setUp()
    {
        $pattern = "/(?<type>\w+)\((?<scope>.+)\):\s(?<subject>.+)/";
        $this-> fixture = new CommitParser($pattern);
    }

    public function testParseReturnsArrayOnMatch()
    {
        $value = 'type(scope): subject';
        $expected = ['type' => 'type', 'scope' => 'scope', 'subject' => 'subject'];
        $this->assertEquals($expected, $this->fixture->parse($value));
    }

    public function testReturnsStringOnMismatch()
    {
        $value = 'message';
        $this->assertEquals($value, $this->fixture->parse($value));
    }
}
