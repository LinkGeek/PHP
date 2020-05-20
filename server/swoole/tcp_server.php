<?php

// TCP服务器

//创建Server对象，监听 127.0.0.1:9501端口
$serv = new Swoole\Server("127.0.0.1", 9501);

//监听连接进入事件
$serv->on('Connect', function ($serv, $fd) {
    echo "Client: {$fd}连接.\n";
    $serv->send($fd, "欢迎{$fd}加藤非\n");
});

//监听数据接收事件
$serv->on('Receive', function ($serv, $fd, $from_id, $data) {
    $serv->send($fd, "服务端回复:{$data}\n");
    foreach ($serv->connections as $connection) {
        if ($connection != $fd){
            $serv->send($connection, "{$fd}说{$data}");
        }
    }
});

//监听连接关闭事件
$serv->on('Close', function ($serv, $fd) {
    echo "Client: {$fd}关闭.\n";
    foreach ($serv->connections as $connection) {
        if ($connection != $fd){
            $serv->send($connection, "{$fd}断开连接");
        }
    }
});

//启动服务器
$serv->start();

// cli命令
// php tcp_server.php

// telnet 127.0.0.1 9501