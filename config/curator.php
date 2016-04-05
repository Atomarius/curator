<?php
return [
    'JiraLinkProcessor.pattern' => '/(?<match>[A-Z]+\-\d+)/',
    'JiraLinkProcessor.replace' => '[<match>](http://myurl/<match>)',
    'CommitParser.pattern' => '/(?<type>\w+)\((?<scope>.+)\):\s(?<subject>.+)/',
    'commit-msg.pattern' => '/\w+\(.+\):\s.+/',
    'MarkdownWriter.processors' => [
        'scope' => 'JiraLinkProcessor',
    ],
    'MarkdownWriter.config'   => [
        'filename' => 'CHANGELOG_TMP.md',
        'list-header-template'  => PHP_EOL . PHP_EOL . '### <type>' . PHP_EOL,
        'list-entry-template'   => '* **<scope>**: <subject>',
        'list-default-template' => '* <default>',
        'sort-by'               => 'type',
        'type'                  => [
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
    ],
];
