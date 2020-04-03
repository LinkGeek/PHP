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
socket_close($socket);