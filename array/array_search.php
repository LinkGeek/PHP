<?php

namespace arr;

// 在一个二维数组中（每个一维数组的长度相同），每一行都按照从左到右递增的顺序排序，
// 每一列都按照从上到下递增的顺序排序。请完成一个函数，输入这样的一个二维数组和一个整数，判断数组中是否含有该整数。

class Test {

    public function test()
    {
        $arr = [
            [1, 2, 8,  9],
            [2, 4, 9,  12],
            [4, 7, 10, 13],
            [6, 8, 11, 15]
        ];
        $target = 15;

        $arr_count = count($arr);
        $ele_count = count($arr[0]);
        $i = $arr_count - 1;
        $j = 0;
        while ($i>=0 && $j < $ele_count) {
            if ($arr[$i][$j] == $target) {
                return true;
            } elseif ($target > $arr[$i][$j]) {
                $j++;
            } else {
                $i--;
            }
        }

        return -1;
    }
}

$obj = new Test();
//var_dump($obj->test());

/**
 * 查找重复的数
 */
function mop($arr) {
    $arr = array_count_values($arr); //统计数组中所有值出现的次数：
    asort($arr); //升序
    $findNum =  end($arr); //end() 函数将内部指针指向数组中的最后一个元素，并输出
    foreach ($arr as $k => $v) {
        if ($v != $findNum) {  //判断$v 是否等于出现最多的次数
            unset($arr[$k]); //unset() — 释放给定的变量
        }
    }
    return array_keys($arr);
}
$testArr = array(1,2,3,1);
var_dump(mop($testArr));