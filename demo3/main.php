<?php

$pool = array();
$pid = pcntl_fork();
if ($pid == -1) {
    die("fork failure");
} elseif ($pid == 0) {
    run();
} else {
    $pool[] = $pid;
    stop($pool);   
}

function run() {
    $aa = SIGINT;
    pcntl_signal(SIGHUP, function($signo) use(&$aa) {
        echo "信号推送成功。\n";
        $aa = $signo;
    });
    $pid = getmypid();
    while(ture) {
        pcntl_signal_dispatch();
        if ($aa == SIGHUP) {
            break;
        }
        echo "p{$pid} start work. \n";
        sleep(1);
        echo "p{$pid} end work. \n";
    }
    echo "p{$pid} finish work. \n";   
}

function stop($pool){
    echo "all pid: \n";
    var_export($pool);
    echo "\n";
    sleep(5);
    foreach ($pool as $p){
        posix_kill($p, SIGHUP);
    }
}
