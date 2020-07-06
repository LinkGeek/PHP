<?php

include 'delayQueue.php';

set_time_limit(0);


$dq = new DelayQueue('close_order', [
    'host' => '127.0.0.1',
    'port' => 6379,
    'auth' => '',
    'timeout' => 60,
]);
$dq->run();
/*while (true) {
    $dq->run();
    usleep(10000);
}*/