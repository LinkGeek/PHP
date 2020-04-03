<?php

/**
 * udp 服务端
 */

set_time_limit(0);

$ip = '192.168.7.105';
$port = 28200;

// 因为无状态，不需要socket_connect和socket_listen，创建时使用SOCK_DGRAM和SOL_UDP两个参数
$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
if ($socket === false) {
    echo "socket_create() failed: " . socket_strerror(socket_last_error())."\n";
}

$ret = socket_bind($socket, $ip, $port);
if ($ret === false) {
    echo "socket_bind() failed: " . socket_strerror(socket_last_error($socket))."\n";
}

while (true) {
    $from = "";
    $port = 0;
    socket_recvfrom($socket, $buf,1024, 0, $from,$port);
    echo "received: $buf from remote address $from and remote port $port" . PHP_EOL;
    usleep(1000);
}