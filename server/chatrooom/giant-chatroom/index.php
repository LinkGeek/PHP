<?php

exec('chcp 65001');
require __DIR__ . '/SocketServer.php';
$socket = new SocketServer();
$socket->start();