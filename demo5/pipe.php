<?php
$fifo = '/Users/renbingdong/pipe.1';

echo "test start\n";
if (!file_exists($fifo)) {
    posix_mkfifo($fifo, 0666);
}
echo "mkfifo success\n";

echo "open write start\n";
$f_write = fopen($fifo, 'w');


echo "open write success\n";
fwrite($f_write, "renbingdong\n");
echo "write finish\n";
sleep(2);
fclose($f_write);
unlink($fifo);
