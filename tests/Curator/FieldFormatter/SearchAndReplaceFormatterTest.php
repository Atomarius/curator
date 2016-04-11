<?php

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
