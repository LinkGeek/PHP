<?php

// Q1 第一个问题关于弱类型
$str1 = 'yabadabadoo';
$str2 = 'yaba';
$pos = strpos($str1, $str2); //0
if ($pos) {
    echo "\"" . $str1 . "\" contains \"" . $str2 . "\"";
}
if ($pos !== false) {
    echo "\"" . $str1 . "\" contains \"" . $str2 . "\"";
}
echo "<hr />";

// Q2 下面的输出结果会是怎样？
$x = 5;
echo $x ."<br />"; //5
echo $x+++$x++ ."<br />"; //11: ($x++)+($x++) => 5+($x++) => 5+6
echo $x."<br />"; //7
echo $x---$x-- ."<br />"; //1: ($x--)-($x--) => 7-($x--) => 7-6
echo $x; //5
echo "<hr />";

$y = 5;
echo $y+++$y+++$y-- ."<br />"; //18: ($y++)+($y++)+($y--) => 5+6+7
echo $y; //6
echo "<hr />";

// Q3 关于变量的引用
$a = '1';
$b = &$a;
$b = "2$b";
var_dump($a, $b); //21 21
echo "<hr />";

// Q4 下面是true还是false
var_dump(0123 == 123); //false
var_dump('0123' == 123); //true
var_dump('0123' === 123); //false
echo "<hr />";

$x = true and false; //$x = true; true and false
var_dump($x); //true
echo "<hr />";

// Q9 下面的输出结果会是什么
$v = 1;
$m = 2;
$l = 3;
if(($l > $m) > $v){
    echo "yes";
}else{
    echo "no";
}
echo "<hr />";

/********************************************  运算 ***************************************************/

$a = 5;
function get_count(){
    static $a;
    return $a++;
}
echo $a .PHP_EOL; // 5
++$a; // 6

echo get_count(); // null
echo get_count(); // 1
echo "<hr />";

$var1 = 5;
$var2 = 10;
function foo(&$my_var) {
    global $var1;
    $var1 += 2;
    $var2 = 4;
    $my_var += 3;
    return $var2;
}

$my_var = 5;
echo foo($my_var). "\n"; //4
echo $my_var. "\n"; //8
echo $var1. "\n"; //7
echo $var2. "\n"; //10

$bar = 'foo';
$my_var = 10;
echo $bar($my_var). "\n"; //4

$a = [];
print_r($a ?? '走了这边');
// []
print_r($a ?: '走了这边');
// 走了这边
echo "<hr />";

/**
 * ip地址⼀一般采⽤用点分⼗十进制的表达⽅方式，请实现⼀一个⽅方法将其转换为点分二进制
 * 要求不使用系统内置进制转换函数
 */
function binIp($ip) {
    $arr = explode('.', $ip);
    $ret = [];
    foreach ($arr as $v) {
        $ret[] = dec2bin($v);
    }
    return implode('.', $ret);
}

/**
 * 把字符串编辑成二进制
 */
function dec2bin($dec) {
    $flag = [];
    while ($dec != 0) {
        array_push($flag, $dec%2);
        $dec = intval($dec/2);
    }
    $binStr = '';
    while (!empty($flag)) {
        $binStr .= array_pop($flag);
    }
    return $binStr;
}
echo dec2bin('39') ."<br/>"; //100111

/**
 * 把字符串编辑成二进制
 */
function str_to_bin($str) {
    //1.列出每个字符
    $arr = preg_split('/(?<!^)(?!$)/u', $str);//var_dump($arr);die;
    //2.unpack字符
    foreach ($arr as &$v) {
        $temp = unpack('H*', $v);
        $v = base_convert($temp[1], 16, 2); //转换为10进制
        unset($temp);
    }

    return join(' ', $arr);
}
echo str_to_bin('39') ."<br/>"; //110001 111001 110010

/**
 * 把二进制转换成字符串
 */
function bin_to_str($str) {
    $arr = explode(' ', $str);
    foreach ($arr as &$v) {
        $v = pack("H" . strlen(base_convert($v, 2, 16)), base_convert($v, 2, 16));
    }

    return join('', $arr);
}
echo bin_to_str('100111') ."<br/>"; //192

$ip = '192.168.1.1';
$result = binIp($ip);
echo $result ."<br/>"; //11000000.10101000.1.1
echo "<hr/>";

echo strlen("http://php.net")."<br/>";
echo @count(strlen("http://php.net"));
echo "<hr/>";

//获取上个月第一天
$prevFirst = date('Y-m-01', strtotime('-1 month'));

//获取上个月最后一天
$prevLast = date('Y-m-t', strtotime('-1 month'));
var_dump($prevFirst, $prevLast);

