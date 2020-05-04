<?php

require ('SocketServer.php');
$socket = new socketServer();
$socket->start();