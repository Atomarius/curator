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

use Curator\InvalidConfigurationException;

class RegexFormatter implements FieldFormatter
{
    /** @var string */
    private $pattern;
    /** @var string */
    private $replace;
    /** @var array */
    private $fields = [];

    /**
     * @param array $config
     */
    public function __construct($config)
    {
        $this->assertConfigIsValid($config);
        $this->pattern = $config['pattern'];
        preg_match_all('/<(\w+)>/', $this->pattern, $fields);
        $this->fields = $fields[1];
        $this->replace = $config['replace'];
    }

    private function assertConfigIsValid($config)
    {
        $required = ['pattern', 'replace'];
        foreach ($required as $field) {
            if (!isset($config[$field])) {
                throw InvalidConfigurationException::create($field);
            }
        }
    }

    public function process($value)
    {
        $matches = [];
        if (preg_match_all($this->pattern, $value, $matches)) {
            foreach ($this->fields as $field) {
                foreach ($matches[$field] as $match) {
                    $replace = str_replace("<{$field}>", $match, $this->replace);
                    $value = str_replace($match, $replace, $value);
                }
            }
        }

        return $value;
    }
}
