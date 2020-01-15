<?php

/************************ 常见的排序算法 ******************************/

$arr = array(1,43,54,62,21,66,32,78,36,76,39);

/**
 1. 冒泡排序
 思路分析：在要排序的一组数中，对当前还未排好的序列，从前往后对相邻的两个数依次进行比较和调整，
 让较大的数往下沉，较小的往上冒。即，每当两相邻的数比较后发现它们的排序与排序要求相反时，就将它们互换。
*/
function bubbleSort($arr) {
    $len = count($arr);
    for ($i=0; $i<$len-1; $i++) {
        for($j=0; $j<$len-$i-1; $j++) {
            if ($arr[$j] > $arr[$j+1]) {
                $tmp = $arr[$j];
                $arr[$j] = $arr[$j+1];
                $arr[$j+1] = $tmp;
            }
        }
    }
    return $arr;
}
$arr1 = bubbleSort($arr);
var_dump($arr1);

/**
2. 快速排序
思路分析：在要排序的一组数中，对当前还未排好的序列，从前往后对相邻的两个数依次进行比较和调整，
让较大的数往下沉，较小的往上冒。即，每当两相邻的数比较后发现它们的排序与排序要求相反时，就将它们互换。
 */
function quickSort($arr) {
    $len = count($arr);
    if ($len <= 1) {
        return $arr;
    }

    $base_num = $arr[0];
    $left_arr = array();
    $right_arr = array();
    for ($i=1; $i<=$len-1; $i++) {
        if ($arr[$i] < $base_num) {
            $left_arr = $arr[$i];
        } else {
            $right_arr = $arr[$i];
        }
    }

    $left_arr = quickSort($left_arr);
    $right_arr = quickSort($right_arr);
    return array_merge($left_arr, array($base_num), $right_arr);
}
$arr2 = quickSort($arr);
var_dump($arr2);