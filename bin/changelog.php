#!/usr/bin/php
<?php
$config = [
    'type' => [
        'feat'     => 'Feature', // A new feature
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

$command = 'git log --pretty=format:%s';
exec($command, $output);

$types = implode('|', array_keys($config['type']));
$pattern = "/(?<type>$types)\((?<scope>.*)\):(?<message>.*)/";
$changelog = [];

foreach ($output as $commit) {
    if (preg_match($pattern, $commit, $matches)) {
        $changelog[$matches['type']][$commit] = $matches;
    } else {
        $changelog['misc'][$commit] = ['scope' => '', 'message' => $commit];
    }
}

foreach (array_keys($changelog) as $type) {
    $type_template = '### %s';
    echo sprintf($type_template, $config['type'][$type]) . PHP_EOL;
    foreach ($changelog[$type] as $change) {
        $template = '-- *%s* %s' . PHP_EOL;
        echo sprintf($template, $change['scope'], trim($change['message']));
    }
}
