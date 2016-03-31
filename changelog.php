#!/usr/bin/php
<?php
$basePath = getcwd();

if (file_exists("$basePath/vendor/autoload.php")) {
    require_once "$basePath/vendor/autoload.php";
}

$config = [
    'pattern' => "/(?<type>.+)\((?<scope>.+)\):(?<message>.+)/",
    'sort-by' => 'type',
    'type'    => [
        'feat'     => 'Features', // A new feature
        'fix'      => 'Bug Fixes', // A bug fix
        'docs'     => 'Documentation', // Documentation only changes
        'style'    => 'Style', // Changes that do not affect the meaning of the code (white-space, formatting, missing semi-colons, etc)
        'refactor' => 'Refactoring', // A code change that neither fixes a bug nor adds a feature
        'perf'     => 'Performance Improvements', // A code change that improves performance
        'test'     => 'Test', // Adding missing tests
        'chore'    => 'Chore', // Changes to the build process or auxiliary tools and libraries such as documentation generation
        'misc'     => 'Miscellaneous'
    ],
];

$commitParser = new \PhpChangelog\CommitParser($config);
$output = (new \PhpChangelog\GitReader())->read();
$messages = [];
foreach ($output as $commit) {
    $messages[] = $commitParser->parse($commit);
}

(new \PhpChangelog\MarkdownWriter($config, 'CHANGELOG.tmp.md'))->write($messages);
