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
    public function regexProvider()
    {
        $configA = [
            'pattern' => '/(?<type>\w+) (?<ticket>[A-Z]+\-\d+ )?(?<scope>.+):\s(?<subject>.+)/',
            'replace' => '* <ticket>**<scope>**: <subject>',
            'index'   => 'type',
        ];
        $configB = [
            'pattern' => '/(?<type>\w+)\((?<scope>.+)\):\s(?<subject>.+)/',
            'replace' => '* **<scope>**: <subject>',
            'index' => 'type',
        ];
        return [
            [ // ticket not provided
                ['index' => 'type', 'message' => '* **scope**: subject'],
                $configA,
                'type scope: subject'
            ],
            [ // ticket provided
                ['index' => 'foo', 'message' => '* FOO-1234 **bar**: subject'],
                $configA,
                'foo FOO-1234 bar: subject'
            ],
            [ // returns array on match
                ['index' => 'type', 'message' => '* **scope**: subject'],
                $configB,
                'type(scope): subject',
            ],
            [ // returns undefined as index and original message
                ['index' => 'undefined', 'message' => 'message'],
                $configB,
                'message',
            ]
        ];  
    }

    /**
     * @dataProvider regexProvider
     * @param array $expected
     * @param array $config
     * @param string $value
     */
    public function testTicketMissing($expected, $config, $value)
    {
        $this->assertEquals($expected, (new CommitFormatter($config, []))->process($value));
    }
}
