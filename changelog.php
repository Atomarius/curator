#!/usr/bin/php
<?php
$basePath = getcwd();

if (file_exists("{$basePath}/vendor/autoload.php")) {
    require_once "{$basePath}/vendor/autoload.php";
}

$config = include "{$basePath}/config/php-changelog.php";

$commitParser = new \PhpChangelog\CommitParser($config);
$output = (new \PhpChangelog\GitReader())->read();
$messages = [];
foreach ($output as $commit) {
    $messages[] = $commitParser->parse($commit);
}

(new \PhpChangelog\MarkdownWriter($config, 'CHANGELOG.tmp.md'))->write($messages);
