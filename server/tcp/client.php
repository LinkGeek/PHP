<?php

/**
 * tcp 客户端
 */

error_reporting(E_ERROR);

/**
 * socket收发数据
 * host(string) socket服务器IP
 * post(int) 端口
 * str(string) 要发送的数据
 * back 1|0 socket端是否有数据返回
 * 返回true|false|服务端数据
*/
function sendSocketMsg($host, $port, $str, $back=0){
    $socket = socket_create(AF_INET,SOCK_STREAM,0);
    if ($socket === false) return false;
    $result = @socket_connect($socket, $host, $port);
    if ($result === false) return false;
    socket_write($socket,$str,strlen($str));
    if($back!=0){
        $input = socket_read($socket,1024);
        socket_close ($socket);
        return $input;
    }else{
        socket_close ($socket);
        return true;
    }
}

// ip、端口
$ip = "192.168.7.105";
$port = 28300;
