<?php
require_once __dir__ . DIRECTORY_SEPARATOR . 'Pool.php';

class Master {
    private $pool;

    public function __construct() {
        echo "work start \n";
        $this->init();
    }
    
    /**
     * 初始化工作
     */
    public function init() {
        $this->pool = new Pool(6);
        $this->pool->initPool();
    }

    public function run() {
        $datas = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15);
        while (!empty($datas)) {
            $data = array_shift($datas);
            $data = 'data:'. $data;
            $this->pool->dispatch($data);        
        }
        echo "work finish \n";        
    }
    
    public function destoryPool() {
            
    }
}
