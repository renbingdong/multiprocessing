<?php
$fifoPath = '/Users/renbingdong/pipe.2';
if (!file_exists($fifoPath)) {
    posix_mkfifo($fifoPath, 0666);
}
echo "test \n";
$f_read = fopen($fifoPath, 'r');
echo "test1 \n";

//$data = fread($f_read, 1024);
//echo $data . "\n";
//sleep(2);

echo "test2 \n";
sleep(10);
$data = fread($f_read, 1024);
echo $data . "\n";

fclose($f_read);
