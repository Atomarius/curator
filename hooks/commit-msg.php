#!/usr/bin/php
<?php
$config = include dirname(__DIR__) . '/config/php-changelog.php';
$line = fgets(fopen($argv[1], 'r'));
if (!preg_match($config['pattern'], $line)) {
    echo '[POLICY] Your message is not formatted correctly';
    exit(1);
}
