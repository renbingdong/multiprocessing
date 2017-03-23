<?php

class Test{

    private $a = 12;
        
    public function run() {
        
        $pid = pcntl_fork();
        if ($pid == -1){
            die("test.");        
        } elseif ($pid == 0) {
            echo "work start. \n";
            pcntl_signal(SIGHUP, function($singo) {
                echo "pcntl_signal \n";
                var_dump($this);
            });
            $i=5;
            while ($i>0) {
                $i--;
                pcntl_signal_dispatch();
                echo "work. \n";
                sleep(1);
           }        
           exit;
        } else {
            sleep(2);
            posix_kill($pid, SIGHUP);
            echo "done \n";        
        }
            
    }

}

(new Test())->run();
