<?php
return [
    'TypeFormatter.config' => [
        'feat'     => 'New Features', // A new feature
        'fix'      => 'Bug Fixes', // A bug fix
        'docs'     => 'Documentation', // Documentation only changes
        'style'    => 'Style', // Changes that do not affect the meaning of the code (white-space, formatting, missing semi-colons, etc)
        'refactor' => 'Refactoring', // A code change that neither fixes a bug nor adds a feature
        'perf'     => 'Performance Improvements', // A code change that improves performance
        'test'     => 'Test', // Adding missing tests
        'chore'    => 'Chore', // Changes to the build process or auxiliary tools and libraries such as documentation generation
        'misc'     => 'Miscellaneous'
    ],
    'JiraLinkFormatter.config'   => [
        'pattern' => '/(?<match>[A-Z]+\-\d+)/',
        'replace' => '[<match>](http://myurl/<match>)',
    ],
    'CommitFormatter.config'     => [
        'pattern' => '/(?<type>\w+)\((?<scope>.+)\):\s(?<subject>.+)/',
        'replace' => '* **<scope>**: <subject>',
        'index'   => 'type',
    ],
    'CommitFormatter.processors' => [
        'scope' => 'JiraLinkFormatter',
    ],
    'ChangelogWriter.config'      => [
        'replace'  => PHP_EOL . PHP_EOL . '### <index>' . PHP_EOL,
        'index'    => [
            'feat'     => 'New Features', // A new feature
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
