<?php

// 异步任务

$server = new Swoole\Server("127.0.0.1", 9505);

//设置异步任务的工作进程数量
$server->set(['task_worker_num' => 4]);

// connect 连接
$server->on("connect", function ($server, $fd) {
    var_dump("client-{$fd}连接");
    $server->send($fd, "欢迎{$fd}加藤非\n");
});

//此回调函数在worker进程中执行
$server->on("receive", function ($server, $fd, $from_id, $data) {
    //投递异步任务
    $task_id = $server->task($data);
    var_dump("触发异步任务ID={$task_id}");
    $server->send($fd, "服务端回复:{$data}\n");
    foreach ($server->connections as $connection) {
        if ($connection != $fd){
            $server->send($connection, "{$fd}说{$data}");
        }
    }
});

//处理异步任务(此回调函数在task进程中执行)
$server->on("task", function ($server, $task_id, $from_id, $data){
    var_dump("新的异步任务[ID={$task_id}]");
    //返回任务执行的结果
    $server->finish("{$data}完成了");
});

//处理异步任务的结果(此回调函数在worker进程中执行)
$server->on("finish", function ($server, $task_id, $data){
    var_dump("异步任务[{$task_id}]已经完成[{$data}]");
});

// close
$server->on("close", function ($server, $fd) {
    var_dump("{$fd}关闭");
    foreach ($server->connections as $connection) {
        if ($connection != $fd){
            $server->send($connection, "{$fd}断开连接");
        }
    }
});

// start
$server->start();

//php async_task.php
//telnet 127.0.0.1 9505