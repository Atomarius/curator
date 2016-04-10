<?php

/*
 * This file is part of Curator.
 *
 * (c) Marius Schütte <marius.schuette@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

function include_if_exists($file)
{
    return file_exists($file) ? include $file : false;
}

if (!include_if_exists(__DIR__ . '/../vendor/autoload.php') && !include_if_exists(__DIR__ . '/../../../autoload.php')) {
    echo 'You must set up the project dependencies using `composer install`' . PHP_EOL;
    exit(1);
}
