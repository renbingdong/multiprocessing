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
fwrite($f_write, "renbingdong1\n");
echo "write finish\n";
fclose($f_write);

echo "open write start\n";
$f_write = fopen($fifo, 'w');

echo "open write success\n";
fwrite($f_write, "renbingdong2\n");
echo "write finish\n";
fclose($f_write);


echo "open write start\n";
$f_write = fopen($fifo, 'w');

echo "open write success\n";
fwrite($f_write, "renbingdong3\n");
echo "write finish\n";
fclose($f_write);


unlink($fifo);
