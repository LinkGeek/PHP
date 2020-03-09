<?php

/**
* strpos(), 左边开始，字符出现第一个位置，区分大小写；
* stripos(),不区分大小写；
* strrpos(), 左边开始，字符出现，最后一个位置，区分大小写；
* strripos()不区分大小写；
*/

$key = 't_welfare_config.task.fypacket';

$pos1 = strpos($key, '.');
$pos2 = stripos($key, '.');
$pos3 = strrpos($key, '.');
$pos4 = strripos($key, '.');
var_dump($pos1, $pos2, $pos3, $pos4);
