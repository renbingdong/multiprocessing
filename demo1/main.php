<?php

$pid = pcntl_fork();

if ($pid == -1) {
    echo 'fork failure' . PHP_EOF;
} elseif ($pid == 0) {
    echo 'I am child.' . PHP_EOF;
} else {
    echo 'I am parent, I fork a child : ' . $pid . PHP_EOF;
}
