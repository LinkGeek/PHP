<?php

/**
 * udp 客户端
 */

$ip = '192.168.7.105';
$port = 28200;

$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
$msg = 'hello udp server,this is upd client msg';
$len = strlen($msg);
socket_sendto($socket, $msg, $len, 0, $ip, $port);

$result = socket_recv($socket, $reply, 1024, MSG_WAITALL);
if ($result === FALSE) {
    echo "socket_recv() failed.\nreason: " . socket_strerror(socket_last_error()) . "\n";
} else {
    echo "read $reply bytes from socket_recv(). Closing socket...";
}
socket_close($socket);