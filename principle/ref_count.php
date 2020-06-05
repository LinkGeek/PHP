<?php

$a = "许铮的技术成长之路";
$b = $a;
$c = &$a;
xdebug_debug_zval("a", "b", "c");

/*$a = "许铮的技术成长之路";
$b = $a;
$c = &$a;
$d = $a;
$e = "许铮的技术成长之路1";
$a = $e;
xdebug_debug_zval("a", "b", "c", "d", "e");*/