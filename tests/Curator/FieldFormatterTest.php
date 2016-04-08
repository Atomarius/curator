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

class FieldFormatterTest extends \PHPUnit_Framework_TestCase
{
    /** @var FieldFormatter */
    private $fixture;

    protected function setUp()
    {
        $config = [
            'pattern' => '/(?<foo>[A-Z]+\-\d+)/',
            'replace' => '[<foo>](http://myurl/<foo>)'
        ];
        $this->fixture = new FieldFormatter($config);
    }

    public function testReplacesMatches()
    {
        $value = 'PSP-1234,SHOP-1234';
        $expected = '[PSP-1234](http://myurl/PSP-1234),[SHOP-1234](http://myurl/SHOP-1234)';
        $this->assertEquals($expected, $this->fixture->process($value));
    }

    public function testLeavesNonMatchingPartsUntouched()
    {
        $value = 'pre,PSP-1234,post';
        $expected = 'pre,[PSP-1234](http://myurl/PSP-1234),post';
        $this->assertEquals($expected, $this->fixture->process($value));
    }

    public function testConsecutiveCallsDoNotInfluenceEachOther()
    {
        $value = 'PSP-1234,SHOP-1234';
        $expected = '[PSP-1234](http://myurl/PSP-1234),[SHOP-1234](http://myurl/SHOP-1234)';
        $this->assertEquals($expected, $this->fixture->process($value));

        $value = 'pre,PSP-1234,post';
        $expected = 'pre,[PSP-1234](http://myurl/PSP-1234),post';
        $this->assertEquals($expected, $this->fixture->process($value));
    }
}
