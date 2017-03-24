<?php
require_once __dir__ . DIRECTORY_SEPARATOR . 'Pipe.php';

class Worker {
    
    private $pid;
    private $is_work;   //是否工作中
    private $pipe;      //管道

    public function __construct() {
        $this->pid = getmypid();
        $this->is_work = false;
        $this->pipe = new Pipe($this->pid);               
    }

    public function run() {
        //wait();
        while (1) {
            $data = $this->pipe->read();
            if (!empty($data)) {
                if (strpos($data, 'data:') === 0) {
                    $data = trim(substr($data, 5));
                    echo "worker {$this->pid} work, data: {$data} \n";        
                }        
            }
            $command = "command:is_waiting";
            $this->pipe->write($command);
        }
                       
    }



    public function wait() {
        pcntl_signal(SIGHUP, function(){
            $this->is_work = true;            
        });
        while (1) {
            pcntl_signal_dispatch();
            if ($this->is_work) {
                break;        
            }
            usleep(100);        
        }         
    }
    
}
