<?php

/**
 * udp 服务端
 * sendto()和 recvfrom()用于在无连接的数据报socket方式下进行数据传输
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
    // 接收地址信息
    $remote_ip = "";
    $remote_port = 0;
    // receive
    socket_recvfrom($socket, $buf,1024, 0, $remote_ip,$remote_port);
    echo "received: $buf from remote address $remote_ip and remote port $remote_port\n";

    // send back
    socket_sendto($socket, "OK", 100, 0, $remote_ip, $remote_port);
}
socket_close($socket);