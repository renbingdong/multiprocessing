<?php

/**
 * 管道类  进程间通信
 */
class Pipe {
    private $fifo_name;     //管道名称
    private $w_pipe;        //管道写端
    private $r_pipe;        //管道读端

    public function __construct($pid, $name = 'pipe', $mode = 0666) {
        $fifo_name = "/Users/renbingdong/pipe/{$name}.{$pid}";
        if (file_exists($fifo_name)) {
            $this->fifo_name = $fifo_name;
            return;        
        }
        $result = posix_mkfifo($fifo_name, $mode);
        if (!$result) {
            echo "The fifo create to be failure. fifo: {$fifo_name}";
            return;        
        }
        $this->fifo_name = $fifo_name;
    }

    /**
     * 读管道
     */
    public function read() {
        $this->r_pipe = fopen($this->fifo_name, 'r');
        $data = fread($this->r_pipe, 1024);
        fclose($this->r_pipe);
        return $data;        
    }

    /**
     * 非阻塞读取管道
     */
    public function unblockRead() {
        $this->r_pipe = fopen($this->fifo_name, 'r');
        stream_set_blocking($this->r_pipe, false);
        usleep(100);
        $data = fread($this->r_pipe, 1024);
        fclose($this->r_pipe);
        return $data;    
    }

    /**
     * 写管道
     */
    public function write($data) {
        $this->w_pipe = fopen($this->fifo_name, 'w');
        fwrite($this->w_pipe, $data);
        fclose($this->w_pipe);    
    }

    public function __destruct() {
        unlink($this->fifo_name);            
    }
}
