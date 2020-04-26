<?php

/**
 * socket 客户端收发数据
 * host(string) socket服务器IP
 * post(int) 端口
 * str(string) 要发送的数据
 * back 1|0 socket端是否有数据返回
 * 返回true|false 服务端数据
 */
function sendSocketMsg($host, $port, $str, $back=0){
    $socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
    if ($socket === false) return false;
    $conn = @socket_connect($socket, $host, $port);
    if ($conn === false) return false;
    $result = socket_write($socket, $str, strlen($str));
    if ($result === false) return false;

    if ($back) {
        $callback = socket_read($socket,1024);
        socket_close ($socket);
        return $callback;
    } else {
        socket_close ($socket);
        return true;
    }
}

// ip、端口
//$host = "192.168.7.105";
$host = "127.0.0.1";
$port = 8080;
$str = "hello server, this is client, can you hear me?";
$result = sendSocketMsg($host, $port, $str, 1);
var_dump($result);