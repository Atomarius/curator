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

$filename = "CHANGELOG.tmp.md";
write_log($filename, $config, $messages);

/**
 * @param string $filename
 * @param array  $config
 * @param array  $messages
 */
function write_log($filename, $config, $messages)
{
    $type_template = PHP_EOL . PHP_EOL . '### %s';
    $template = PHP_EOL . '* **%s**: %s';
    file_exists($filename) && unlink($filename);
    foreach (array_keys($config[$config['sort-by']]) as $type) {
        $data = sprintf($type_template, $config[$config['sort-by']][$type]);
        file_put_contents($filename, $data, FILE_APPEND);
        foreach ($messages as $message) {
            if (is_array($message) && isset($message[$config['sort-by']]) && $message[$config['sort-by']] == $type) {
                $data = sprintf($template, trim($message['scope']), trim($message['message']));
                file_put_contents($filename, $data, FILE_APPEND);
            }
        }
    }

    if (!empty($uncategorized)) {
        $data = sprintf($type_template, 'Uncategorized');
        file_put_contents($filename, $data, FILE_APPEND);
        foreach ($uncategorized as $message) {
            if (is_string($message)) {
                $data = sprintf($template, 'none', trim($message));
                file_put_contents($filename, $data, FILE_APPEND);
            }
        }
    }
}
