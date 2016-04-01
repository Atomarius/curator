<?php
chdir(dirname(__DIR__));
symlink('../../hooks/commit-msg.php', '.git/hooks/commit-msg');
