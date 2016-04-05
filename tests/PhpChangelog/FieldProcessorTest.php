<?php

namespace PhpChangelog;

class FieldProcessorTest extends \PHPUnit_Framework_TestCase
{
    /** @var FieldProcessor */
    private $fixture;

    protected function setUp()
    {
        $pattern = '/[A-Z]+\-\d+/';
        $replace = '[<match>](http://myurl/<match>)';
        $this->fixture = new FieldProcessor($pattern, $replace);
    }

    public function testReplacesMatches()
    {
        $value = 'PSP-1234,SHOP-1234';
        $expected = '[PSP-1234](http://myurl/PSP-1234)'
            . ',[SHOP-1234](http://myurl/SHOP-1234)';
        $this->assertEquals($expected, $this->fixture->process($value));
    }

    public function testLeavesNonMatchingPartsUntouched()
    {
        $value = 'pre,PSP-1234,post';
        $expected = 'pre,[PSP-1234](http://myurl/PSP-1234),post';
        $this->assertEquals($expected, $this->fixture->process($value));
    }
}
