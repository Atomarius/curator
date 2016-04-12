<?php

/*
 * This file is part of Curator.
 *
 * (c) Marius Schütte <marius.schuette@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Curator\FieldFormatter;

class SearchAndReplaceFormatterTest extends \PHPUnit_Framework_TestCase
{
    public function testSimpleReplace()
    {
        $config = ['apple' => 'orange'];
        $formatter = new SearchAndReplaceFormatter($config);
        $subject = 'my apple';

        $this->assertEquals('my orange', $formatter->process($subject));
    }

    public function testMultiReplace()
    {
        $config = ['apple' => 'orange', 'my' => 'your'];
        $formatter = new SearchAndReplaceFormatter($config);
        $subject = 'my apple';

        $this->assertEquals('your orange', $formatter->process($subject));
    }
}
