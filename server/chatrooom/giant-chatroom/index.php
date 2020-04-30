<?php

exec('chcp 65001');
//根目录
define('ROOT_PATH', __DIR__ . '/');

//日志目录
define('LOG_PATH', __DIR__ . '/data/logs/');
require ('SocketServer.php');
require './public/lib/Helper.php';
require './public/lib/Error.php';
$error = new lib\Error();
$socket = new socketServer();

$socket->start();