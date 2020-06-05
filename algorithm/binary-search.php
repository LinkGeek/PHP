<?php

// 二分查找算法

/**
 * 循环实现
 * @param $arr
 * @param $num
 * @return bool|int
 */
function binary_search($arr, $num)
{
    if (!is_array($arr) || empty($arr)) {
        return false;
    }

    $len = count($arr);
    $start = 0;
    $end = $len - 1;

    while ($end >= $start) {
        $middle = intval(($start + $end) / 2);
        if ($num > $arr[$middle]) {
            $start = $middle + 1;
        } elseif ($num < $arr[$middle]) {
            $end = $middle - 1;
        } else {
            return $middle;
        }
    }

    return false;
}

$arr = [1,3,6,9,13,18,19,29,38,47,51,56,58,59,60,63,65,69,70,71,73,75,76,77,79,89];
$find_key = binary_search($arr, 73);
print_r($find_key);

/**
 * 递归实现
 * @param $arr
 * @param $num
 * @param $start
 * @param $end
 * @return bool|int
 */
function binary_search_recursion($arr, $num, $start, $end)
{
    if ($start > $end) {
        return false;
    }

    $middle = intval(($start + $end) / 2);
    if ($num > $arr[$middle]) {
        $start = $middle + 1;
        //判断边界值
        if($start >= $end){
            return false;
        }
        return binary_search_recursion($arr, $num, $start, $end);
    } elseif ($num < $arr[$middle]) {
        $end = $middle - 1;
        //判断边界值
        if($end < 0){
            return false;
        }
        return binary_search_recursion($arr, $num, $start, $end);
    } else {
        return $middle;
    }
}

$find_key_r = binary_search_recursion($arr, 73, 0, count($arr));
print_r($find_key_r);


/**
 * 关联数组的二分查找算法
 * @param $arr
 * @param $target
 * @return bool|int
 */
function binary_assoc_search($arr, $target) {
    $low = 0;
    $high = count($arr) - 1;
    $key_map = array_keys($arr);
    while (true) {
        if ($low > $high) {
            break;
        }

        $middle = intval(($low + $high) / 2);
        if ($arr[$key_map[$middle]] == $target) {
            return $middle;
        } elseif ($arr[$key_map[$middle]] < $target) {
            $low = $middle + 1;
        } else {
            $high = $middle + 1;
        }
    }

    return false;
}

$array = ['a'=>1,'b'=>3,'c'=>6,'d'=>9,'e'=>13,'f'=>18,'g'=>19,'h'=>29,'i'=>38];
$target = 19;
$assoc_idx = binary_assoc_search($array, $target);
print_r($assoc_idx);