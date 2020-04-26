<?php
exec('chcp 65001');
require ('SocketServer.php');
$socket = new socketServer();
$socket->start();