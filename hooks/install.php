<?php
chdir(dirname(__DIR__));
file_exists('.git/hooks/commit-msg') || symlink('../../hooks/commit-msg.php', '.git/hooks/commit-msg');
