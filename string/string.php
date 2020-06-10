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
// 全排列就是从n个不同元素中任取m（m≤n）个元素，按照一定的顺序排列起来，叫做从n个不同元素中取出m个元素的一个排列，
// 当m=n时所有的排列情况叫全排列。
$str = 'abc';

// 字符串转换为数组
$arr = str_split($str);

// 调用perm函数
perm($arr, 0,count($arr) - 1);

/**
 * 定义perm函数
 * @param $arr // 排列的字符串
 * @param $k // 初始值
 * @param $m // 最大值
 */
function perm(&$arr, $k, $m)
{
    // 初始值是否等于最大值
    if ($k == $m) {
        // 将数组转换为字符串
        echo join('', $arr), PHP_EOL;
    } else {
        // 循环调用函数
        for ($i = $k; $i <= $m; $i++) {
            // 调用swap函数
            swap($arr[$k], $arr[$i]);
            // 递归调用自己
            perm($arr, $k + 1, $m);
            // 再次调用swap函数
            swap($arr[$k], $arr[$i]);
            //var_dump($arr);
        }
    }
}

function swap(&$a, &$b)
{
    $c = $a;
    $a = $b;
    $b = $c;
}
