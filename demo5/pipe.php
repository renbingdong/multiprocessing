<?php
$fifo = '/Users/renbingdong/pipe.1';

echo "test start\n";

posix_mkfifo($fifo, 0666);
echo "mkfifo success\n";

echo "open write start\n";
$f_write = fopen($fifo, 'w');

stream_set_blocking($f_write, false);

echo "open write success\n";

fwrite($f_write, "test");

echo "write finish\n";

fclose($f_write);
unlink($fifo);
