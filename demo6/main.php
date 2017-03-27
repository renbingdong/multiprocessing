<?php

$pid = pcntl_fork();
if ($pid == -1) {
    die("fork failure \n");
} elseif ($pid == 0) {
    echo "子进程开始执行 \n";
    $pid = getmypid();
    $fifo = pipe($pid);
    $test = false;
    pcntl_signal(SIGUSR1, function($signo){
        global $test;
        $test = true;
    });
    for ($i = 0; $i < 3; $i++) {
        while (1) {
            $test = false;
            pcntl_signal_dispatch();
            if ($test) {
                break;
            }
            usleep(10);
        }
        echo "子进程read：{$i}\n";
        $f_read = fopen($fifo, 'r');
        $data = fread($f_read, 1024);
        echo $data . "\n";
        fclose($f_read);
    }
    exit();
} else {
    sleep(1);
    echo "父进程开始执行 \n";
    $fifo = pipe($pid);
    for ($i = 0; $i < 3; $i++) {
        echo "父进程write：{$i} \n";
        posix_kill($pid, SIGUSR1);
        $f_write = fopen($fifo, 'w');
        fwrite($f_write, 'a' . $i);
        fclose($f_write);
        usleep(300);
    }
    unlink($fifo);
}


function pipe($pid) {
    $fifo = "/Users/renbingdong/pipe.{$pid}";
    if (!file_exists($fifo)) {
        posix_mkfifo($fifo, 0666);
    }
    return $fifo;
}
