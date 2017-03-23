<?php

class Master {

    private $max_pool_size; //进程池最大进程数
    private $pool;          //进程池
    private $free_pool;     //空闲进程池

    public function __construct($max_pool_size = 5) {
        $this->max_pool_size = $max_pool_size;
    }
    
    /**
     * 初始化进程池
     */
    public function initPool() {
        for ($i = 0; $i < $this->max_pool_size; $i++) {
            $pid = pcntl_fork();
            if ($pid == -1) {
                echo "进程创建失败";
                continue;
            } elseif ($pid == 0) {
                $worker = new Worker();
                $worker->run();
                exit();        
            } else {
                $pool[] = $pid;        
                $free_pool[] = $pid;
            }
        }
    }
    
    public function dispatch() {
        $datas = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15);
        while (!empty($data)) {
            $data = array_shift($datas);
            $index = rand(0, count($this->free_pool));
            $pid = $this->free_pool[$index];
            unset($this->free_pool[$index]);
            $this->free_pool = array_values($this->free_pool);
                    
        }                       
    }

    public function destoryPool() {
            
    }
}
