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
    echo "socket_bind() failed: " . socket_strerror(socket_last_error())."\n";
}

while (true) {
    $remote_ip = "";
    $remote_port = 0;
    // receive
    socket_recvfrom($socket, $buf,1024, 0, $remote_ip,$remote_port);
    echo "received: $buf from remote address $remote_ip and remote port $remote_port" . PHP_EOL;

    // send back
    socket_sendto($socket, "OK " . $buf, 100, 0, $remote_ip, $remote_port);
}
socket_close($socket);