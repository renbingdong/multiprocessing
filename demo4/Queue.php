<?php

class Queue {

    private static $queue;     //进程队列

    public function initQueue($pid) {
                
    }
    
    public function putQueue($pid, $message) {
        if (!isset($this->queue[$pid])) {
            $this->queue[$pid] = array();        
        }
        $this->queue[$pid][] = $message;         
    }
    
    public function getQueue($pid) {
                
    }         
}
