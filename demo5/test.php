<?php
//$fifoPath = '/Users/renbingdong/pipe.1';
$fifoPath = '/Users/renbingdong/pipe/pipe.69505';
if (!file_exists($fifoPath)) {
    posix_mkfifo($fifoPath, 0666);
}
echo "test \n";
$f_read = fopen($fifoPath, 'r');
stream_set_blocking($f_read, false);
usleep(10);
echo "test1 \n";
$data = fread($f_read, 1024);
echo $data . "\n";

fclose($f_read);
