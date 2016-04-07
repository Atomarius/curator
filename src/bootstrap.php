<?php
function include_if_exists($file)
{
    return file_exists($file) ? include $file : false;
}

if ((!include_if_exists(__DIR__ . '/../vendor/autoload.php')) && (!include_if_exists(__DIR__ . '/../../../autoload.php'))) {
    echo 'You must set up the project dependencies using `composer install`' . PHP_EOL;
    exit(1);
}
