<?php

$num = 5;
$location = 'tree';

$format = 'There are %d monkeys in the %s';
echo sprintf($format, $num, $location)."<br>";
// There are 5 monkeys in the tree

$num1 = 1234567890123;
$num2 = -123456789;
$char = 50; // ASCII 字符 50 是 2

// 注释：格式值 "%%" 返回百分号
echo '$num1: '."$num1, ".'$num2: '."$num2, ".'$char: '."$char"."<br>";
echo sprintf("%%b = %b", $num1)."<br>"; // 二进制数
echo sprintf("%%c = %c", $char)."<br>"; // ASCII 字符
echo sprintf("%%d = %d", $num1)."<br>"; // 带符号的十进制数
echo sprintf("%%d = %d", $num2)."<br>"; // 带符号的十进制数
echo sprintf("%%e = %e", $num1)."<br>"; // 科学计数法（小写）
echo sprintf("%%E = %E", $num1)."<br>"; // 科学计数法（大写）
echo sprintf("%%u = %u", $num1)."<br>"; // 不带符号的十进制数（正）
echo sprintf("%%u = %u", $num2)."<br>"; // 不带符号的十进制数（负）
echo sprintf("%%f = %f", $num1)."<br>"; // 浮点数（视本地设置）
echo sprintf("%%F = %F", $num1)."<br>"; // 浮点数（不视本地设置）
echo sprintf("%%g = %g", $num1)."<br>"; // 短于 %e 和 %f
echo sprintf("%%G = %G", $num1)."<br>"; // 短于 %E 和 %f
echo sprintf("%%o = %o", $num1)."<br>"; // 八进制数
echo sprintf("%%s = %s", $num1)."<br>"; // 字符串
echo sprintf("%%x = %x", $num1)."<br>"; // 十六进制数（小写）
echo sprintf("%%X = %X", $num1)."<br>"; // 十六进制数（大写）
echo sprintf("%%+d = %+d", $num1)."<br>"; // 符号说明符（正）
echo sprintf("%%+d = %+d", $num2)."<br>"; // 符号说明符（负）
echo "<hr/>";

// 验证码相关
$dymcCodeRedisFormat = [
    'infoKey'     => 'AC|%d|%d|%d',                // 验证码有效期redis  `AC|$phoneNum|$sendCase|$flagId`
    'intervalKey' => 'INTERVAL_LOCK|AC|%d|%d|%d',  // 验证码间隔时间锁   `INTERVAL_LOCK|$phoneNum|$sendCase|$flagId`
    'rateKey'     => 'RATE_LOCK|AC|%d|%d|%d',      // 验证码频率锁       `RATE_LOCK|$phoneNum|$sendCase|$flagId`
    'sendKey'     => 'dymcCodeSendQueue|%d',       // 验证码发送队列     `dymcCodeSendQueue|$flagId`
    'sendFormat'  => '%d|%d|%d'                    // 验证码发送队列value格式 $phoneNum|$dymcCode|$sendCase
];

$phone = 18318678052;
$sendCase = 4156;
$dymcCodeKey = sprintf('%d|%d|%d', $phone, $sendCase, 111);
var_dump($dymcCodeKey);