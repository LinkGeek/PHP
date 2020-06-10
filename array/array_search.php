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
var_dump($obj->test());