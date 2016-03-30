#!/usr/bin/php
<?php
chdir(getcwd());

$config = [
    'message-pattern' => "/(?<type>.*)\((?<scope>.*)\):(?<message>.*)/",
    'type'            => [
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

$options = [];
$options['from'] = isset($options['from']) ? $options['from'] : '';
$options['to'] = isset($options['to']) ? $options['to'] : 'HEAD';

$range = !empty($options['from']) ? implode('..', [$options['from'], $options['to']]) : $options['to'];
$command = "git log {$range} --pretty=format:%s";

exec($command, $output);

$changelog = parse_commits($config, $output);
$filename = "CHANGELOG-{$range}.md";
write_log($filename, $config, $changelog);

/**
 * @param array $config
 * @param array $content
 *
 * @return array
 */
function parse_commits($config, $content)
{
    $changelog = [];
    preg_match_all('/<(\w*)>/', $config['message-pattern'], $fields);

    foreach ($content as $commit) {
        $message = [];
        if (preg_match($config['message-pattern'], $commit, $matches)) {
            foreach ($fields[1] as $field) {
                $message[$field] = isset($matches[$field]) ? $matches[$field] : 'misc';
            }
            $changelog[$message['type']][$commit] = $message;
        } else {
            $changelog['ignored'][$commit] = $commit;
        }
    }

    return $changelog;
}

/**
 * @param string $filename
 * @param array $config
 * @param array $changelog
 */
function write_log($filename, $config, $changelog)
{
    $type_template = PHP_EOL . PHP_EOL . '### %s';
    $template = PHP_EOL . '* *%s*: %s';
    file_exists($filename) && unlink($filename);
    foreach (array_keys($config['type']) as $type) {
        if (isset($changelog[$type])) {
            $data = sprintf($type_template, $config['type'][$type]);
            file_put_contents($filename, $data, FILE_APPEND);
            foreach ($changelog[$type] as $message) {
                $data = sprintf($template, trim($message['scope']), trim($message['message']));
                file_put_contents($filename, $data, FILE_APPEND);
            }
        }
    }
    if (isset($changelog['ignored'])) {
        $data = sprintf($type_template, 'None');
        file_put_contents($filename, $data, FILE_APPEND);
        foreach ($changelog['ignored'] as $message) {
            $data = sprintf($template, 'none', trim($message));
            file_put_contents($filename, $data, FILE_APPEND);
        }
    }
}
