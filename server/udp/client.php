<?php

/**
 * udp 客户端
 */

$ip = '192.168.7.105';
$port = 28200;

$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
$msg = 'hello udp server, this is upd client msg';
$len = strlen($msg);
socket_sendto($socket, $msg, $len, 0, $ip, $port);

$result = socket_recv($socket, $reply, 1024, MSG_WAITALL);
if ($result === FALSE) {
    echo "socket_recv() failed.\nreason: " . socket_strerror(socket_last_error()) . "\n";
} else {
<<<<<<< HEAD
    echo "read $reply bytes from socket_recv(). Closing socket...";
=======
    echo "server replay: $reply. Closing socket...\n";
>>>>>>> 0ab3472048187ba738756f425abfe570b10abff9
}
socket_close($socket);