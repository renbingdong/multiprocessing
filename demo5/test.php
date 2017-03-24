<?php
$fifoPath = '/Users/renbingdong/pipe.1';

echo "test";
$f_read = fopen($fifoPath, 'r');
echo "test1";

$data = fread($f_read, 1024);
echo $data;

fclose($f_read);
