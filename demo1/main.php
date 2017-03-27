<?php

$pid = pcntl_fork();

if ($pid == -1) {
    echo 'fork failure' . PHP_EOF;
} elseif ($pid == 0) {
    echo "I am child. \n";
} else {
    echo "I am parent, I fork a child : {$pid}\n";
    echo pcntl_waitpid($pid, $status);
    echo "\n";
}
