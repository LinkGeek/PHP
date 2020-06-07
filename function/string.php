<?php

// 说明：获取 abc.jpeg 后缀名
$fileName = 'abc.jpeg';
//echo substr($fileName, strrpos($fileName, "."));
// 输出：.jpeg

//echo substr($fileName, strrpos($fileName, "."), 2);
// 输出：.j

$str = explode('.', $fileName);
//var_dump($str);

// 题目为：php给定一个字符串，输出字符串的所有排列，例如给定字符串abc，打印出a，b，c所能排列出的所有组合abc，acb，bac，bca，cab，cba

/**

 * 输入一个字符串，打印出该字符串中字符的所有排列

 * @param unknown $arr    字符串转化的数组

 * @param unknown $start  开始位置

 * @param unknown $len  字符串长度

 */



function test3(&$arr,$start,$len){

    if ($start== $len){

        //echo join('', $arr),PHP_EOL;

    }else {

        for ($i=$start;$i<=$len;$i++){

            test4($arr[$start],$arr[$i]);

            test3($arr, $start+1,$len);

            test4($arr[$start],$arr[$i]);

        }

    }

}



/**

 * 字符交换位置

 * @param unknown $a

 * @param unknown $b

 */



function test4(&$a,&$b){

    $tmp = $a;

    $a = $b;

    $b = $tmp;

}

$str = 'abcd';

$arr = str_split($str);

$len = count($arr)-1;

test3($arr,0, $len);
//var_dump($arr);