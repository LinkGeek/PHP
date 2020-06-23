<?php

// 1.静态变量
function callStatic(){
    static $i = 0;
    echo $i . '';
    $i++;

    if($i < 10){
        callStatic();
    }
}
//callStatic();

// 2.全局变量
$i = 1;
function callGlobal(){
    global $i;
    echo $i;
    $i++;
    if($i <= 10){
        callGlobal();
    }
}
//callGlobal();

/**
 * 引用传参
 */
function test($a=0, &$ret=[]) {
    $a++;
    if($a < 10) {
        $ret[] = $a;
        test($a, $ret);
    }
    echo $a."<hr/>"; // 10 -> 1
    return $ret;
}
//var_dump(test());