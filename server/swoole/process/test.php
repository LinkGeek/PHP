<?php

use Swoole\Process;

$process = new Process(function (Process $proc) {
    echo 'Child #' . getmypid() . " start and sleep 3s" . PHP_EOL;
    $proc->exec("/usr/local/php7/bin/php", [__DIR__.'/../http_server.php']);
});

$process->start();
