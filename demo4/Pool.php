<?php
require_once __dir__ . DIRECTORY_SEPARATOR . 'Worker.php';
require_once __dir__ . DIRECTORY_SEPARATOR . 'Pipe.php';

/**
 * 进程池  维护worker进程信息
 */
class Pool {
    private $max_size;      //最大worker进程数量
    private $pool;          //进程池
    private $free_pool;     //空闲进程池
    private $busy_pool;     //工作进程池
    private $pipe_pool;     //管道池

    public function __construct($max_size = 5) {
        $this->max_size = $max_size;        
        $this->pool = array();
        $this->free_pool = array();
        $this->busy_pool = array();
        $this->pipe_pool = array();
    }

    /**
     * 初始化进程池
     */
    public function initPool() {
        echo "开始创建进程 \n";
        for ($i = 0; $i < $this->max_size; $i++) {
            $pid = pcntl_fork();
            if ($pid == -1) {
                echo "进程创建失败";
                continue;
            } elseif ($pid == 0) {
                $worker = new Worker();
                $worker->run();
                exit();
            } else {
                $this->pool[$pid] = $pid;
                $this->free_pool[] = $pid;
                $pipe = new Pipe($pid);
                $this->pipe_pool[$pid] = $pipe;
                echo "进程{$pid}创建成功 \n";
            }
        }        
    }

    /**
     * 分配任务
     */
    public function dispatch($data) {
        $pid = $this->getFreeWorker();
        echo "dispatch worker {$pid}, data: {$data} \n";
        $pipe = $this->pipe_pool[$pid];
        $pipe->write($data);    
    }
    
    /**
     * 获取当前可用的空闲进程
     */
    public function getFreeWorker() {
        while (1) {
            if (!empty($this->free_pool)) {
                $pid = array_shift($this->free_pool);
                array_push($this->busy_pool, $pid);
                return $pid;
            }
            $this->_refresh();
            usleep(100);        
        }
    }

    /**
     * 刷新进程池
     */
    private function _refresh() {
        foreach ($this->busy_pool as $key => $pid) {
            $pipe = $this->pipe_pool[$pid];
            $data = $pipe->unblockRead();
            if (!empty($data)) {
                if (strpos($data, 'command:') === 0) {
                    $command = trim(substr($data, 8));
                    if ($command == 'is_waiting') {
                        array_push($this->free_pool, $pid);
                        unset($this->busy_pool[$key]);
                    }        
                }        
            }        
        }
        $this->busy_pool = array_values($this->busy_pool);        
    }
        
}
