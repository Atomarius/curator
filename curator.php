#!/usr/bin/php
<?php

$dir = [
    'cwd' => getcwd(),
    'app' => __DIR__,
];

if (file_exists("{$dir['cwd']}/vendor/autoload.php")) {
    require_once "{$dir['cwd']}/vendor/autoload.php";
}

$definitions = [];
$definitions = include "{$dir['app']}/config/curator.php";

foreach ($dir as $directory) {
    if (file_exists("{$directory}/config/php-changelog.php")) {
        $definitions = array_replace_recursive($definitions, include "{$directory}/config/curator.php");
    }
}

$definitions = array_replace_recursive($definitions, include __DIR__ . '/config/services.php');

// creating lightweight DI container
$container = \Curator\Application\ContainerBuilder::build($definitions);
$container->get('Application')->run();
