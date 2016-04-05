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

foreach ($dir as $directory) {
    if (file_exists("{$directory}/config/curator.php")) {
        $definitions = array_replace_recursive($definitions, include "{$directory}/config/curator.php");
    }
}

$definitions = array_replace_recursive($definitions, include "{$dir['app']}/config/services.php");

// creating lightweight DI container
$container = \Curator\Application\ContainerBuilder::build($definitions);
$container->get('Application')->run();
