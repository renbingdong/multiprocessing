<?php
require_once __dir__ . DIRECTORY_SEPARATOR . 'Pipe.php';

class Worker {
    
    private $pid;
    private $is_start;  //是否开始工作
    private $is_quit;   //当前进程是否退出
    private $pipe;      //管道

    public function __construct() {
        $this->pid = getmypid();
        $this->is_work = false;
        $this->is_quit = false;
        $this->pipe = new Pipe($this->pid);               
    }

    public function run() {
        while (1) {
            $this->wait();
            $data = $this->pipe->read();
            if (!empty($data)) {
                if (strpos($data, 'data:') === 0) {
                    $data = trim(substr($data, 5));
                    echo "worker {$this->pid} work, data: {$data} \n";        
                }        
            }
            $command = "command:is_waiting";
            $this->pipe->write($command);
            $this->is_start = false;
        }
                       
    }
    
    /**
     * 进程阻塞，等待执行任务，或者结束进程
     */
    private function wait() {
        pcntl_signal(SIGUSR1, function(){
            $this->is_start = true;            
        });
        pcntl_signal(SIGUSR2, function(){
            $this->is_quit = true;
        });
        while (1) {
            pcntl_signal_dispatch();
            if ($this->is_start) {
                break;        
            }
            if ($this->is_quit) {
                echo "进程{$this->pid}，结束执行\n";
                exit;
            }
            usleep(10);        
        }         
    }
    
}
