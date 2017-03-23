<?php

class Worker {
    
    private $pid;
    private $is_work;   //是否工作中

    public function __construct() {
        $this->pid = getmypid();
        $this->is_work = false;               
    }

    public function run() {
        wait();            
    }

    public function wait() {
        pcntl_signal(SIGHUP, function(){
            $this->is_work = true;            
        });
        while (1) {
            pcntl_signal_dispatch();
            if ($this-is_work) {
                break;        
            }
            usleep(100);        
        }         
    }
    
}
