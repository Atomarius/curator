#!/usr/bin/php
<?php
$config = include dirname(__DIR__) . '/config/curator.php';
$line = fgets(fopen($argv[1], 'r'));
if (!preg_match($config['commit-msg.pattern'], $line)) {
    echo '[POLICY] Your message is not formatted correctly';
    exit(1);
}
