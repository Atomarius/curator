<?php

namespace PhpChangelog;

class FieldProcessorTest extends \PHPUnit_Framework_TestCase
{
    /** @var FieldProcessor */
    private $fixture;
    protected function setUp()
    {
        $this->fixture = new FieldProcessor();
    }

    public function testReplaceMatchesWithLink()
    {
        $value = 'PSP-1234,SHOP-1234';
        $expected = '[PSP-1234](http://jira.goodgamestudios.com/browse/PSP-1234)'
            . ',[SHOP-1234](http://jira.goodgamestudios.com/browse/SHOP-1234)';
        $this->assertEquals($expected, $this->fixture->process($value));
    }
}
