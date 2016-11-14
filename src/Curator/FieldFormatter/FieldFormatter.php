<?php

namespace Curator\FieldFormatter;

interface FieldFormatter
{
    /**
     * @param string $value
     *
     * @return string
     */
    public function process($value);
}
