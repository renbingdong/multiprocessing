<?php

$fifoPath = '/Users/renbingdong/pipe.1';
if (!posix_mkfifo($fifoPath, 0666)) {
    die("The fifo create to be failure");        
}
echo "The fifo create to be successfull \n";

$f_write = fopen($fifoPath, 'w');
if (!$f_write) {
    die("The fwrite create to be failure");        
}
echo "The fwrite create to be successfull \n";
$f_read = fopen($fifoPath, 'r');
if (!$f_read) {
    die("The fread create to be failure");        
}
echo "The fread create to be successfull \n";
echo "Read the fifo.. \n";


