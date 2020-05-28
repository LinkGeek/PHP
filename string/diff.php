<?php

echo 'php版本:'.PHP_VERSION; //5.6.28

$a =  0;
$b="0";
$c= '';
$d= null;
$e = false;

echo "5个变量-原始测试类型";
var_dump($a);//int 0
var_dump($b);//string '0'
var_dump($c);//string ''
var_dump($d);//null
var_dump($e);//boolean false

echo "<h4>empty测试</h4>";
var_dump(empty($a));//true
var_dump(empty($b));//true
var_dump(empty($c));//true
var_dump(empty($d));//true
var_dump(empty($e));//true

echo "<hr>";
var_dump(isset($a));//true
var_dump(isset($b));//true
var_dump(isset($c));//true
var_dump(isset($d));//【false】 见结论一
var_dump(isset($e));//true

echo "<h4>（==）双等式测试</h4>";
var_dump($a == $b);//true
var_dump($a == $c);//true
var_dump($a == $d);//true
var_dump($a == $e);//true ！！

var_dump($b == $c);//【false】见结论二
var_dump($b == $d);//【false】见结论二
var_dump($b == $e);//true

var_dump($c == $d);//true
var_dump($c == $e);//true

echo "<h4>（===）三等式测试</h4>";
var_dump($a === $b);//false
var_dump($a === $c);//false
var_dump($a === $d);//false
var_dump($a === $e);//false

var_dump($b === $c);//false
var_dump($b === $d);//false
var_dump($b === $e);//false

var_dump($c === $d);//false
var_dump($c === $e);//false