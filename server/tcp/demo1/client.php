<?php

/**
 * tcp 客户端
 */

error_reporting(E_ERROR);

// ip、端口
$ip = "192.168.7.105";
$port = 28300;

// 创建一个socket套接流
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
}

// 连接服务端的套接流，这一步就是使客户端与服务器端的套接流建立联系
echo "试图连接服务器： '$ip' 端口 '$port'...\n";
$result = socket_connect($socket, $ip, $port);
if ($result === false) {
    echo "socket_connect() failed.\nReason: " . socket_strerror(socket_last_error()) . "\n";
} else {
    echo "connect success!\n";
}

// 发送
$msg = "hello server, this is client, can you hear me?";
if (!socket_write($socket, $msg)) {
    echo "socket_write() failed.\nReason: " . socket_strerror(socket_last_error()) . "\n";
} else {
    echo "send msg: ". $msg."\n";
}

// 读取服务端返回来的套接流信息
while($callback = socket_read($socket, 1024)) {
    echo "server response: ". $callback."\n";
}

// 关闭套接流
echo "关闭socket...\n";
socket_close($socket);