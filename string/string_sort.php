<?php

namespace string;

// 题目为：php给定一个字符串，输出字符串的所有排列，例如给定字符串abc，打印出a，b，c所能排列出的所有组合abc，acb，bac，bca，cab，cba
// 全排列就是从n个不同元素中任取m（m≤n）个元素，按照一定的顺序排列起来，叫做从n个不同元素中取出m个元素的一个排列，
// 当m=n时所有的排列情况叫全排列。

/**
 * 值互换
 */
function swap(&$left, &$right)
{
    $tmp   = $left;
    $left  = $right;
    $right = $tmp;
}

/**
 * 字符串的排列，非重复字符
 * Class strSingleSort
 * @package string
 */
class strSingleSort {

    /**
     * @param $str
     * @return array
     */
    public function permutation($str)
    {
        // 字符串转换为数组
        $arr = str_split($str);

        // 存放最终结果的数组
        $res = [];

        // 调用perm函数
        $this->perm($arr, $res,0,count($arr) - 1);
        return $res;
    }

    /**
     * 定义perm函数
     * @param $arr // 排列的字符串
     * @param $res // 最终结果
     * @param $k // 初始值
     * @param $m // 最大值
     */
    function perm(&$arr, &$res, $k, $m)
    {
        // 初始值是否等于最大值
        if ($k == $m) {
            // 将数组转换为字符串
            //echo join('', $arr), PHP_EOL;
            $res[] = join('', $arr);
            return;
        }

        // 循环调用函数
        for ($i = $k; $i <= $m; $i++) {
            // 调用swap函数
            swap($arr[$k], $arr[$i]);
            // 递归调用自己
            $this->perm($arr, $res,$k + 1, $m);
            // 再次调用swap函数
            swap($arr[$k], $arr[$i]);
        }
    }
}


/**
 * 字符串的排列，兼容重复字符
 * Class strRepeatSort
 * @package string
 */
class strRepeatSort
{
    /**
     * 排列函数
     */
    public function permutation($str)
    {
        if (empty($str)) return [];

        $arr   = str_split($str);  // 字符串转数组
        $res   = [];               // 存放最终结果的数组
        $print = '';               // 存放每次的排序

        $this->dfs(0, $arr,$res, $print);  // 调用函数
        return $res;
    }

    /**
     * @param $index  表示正在固定位置的字符下标
     * @param $arr    字符串转换而来的数组
     * @param $res    存放全部排序的数组
     * @param $print  存放每次排序的字符串
     */
    public function dfs($index, $arr, &$res, $print)
    {
        $length = count($arr);

        // 如果遍历到最后一个字符，则将排完序的字符串放进 $res[]
        if ($index == $length - 1) {
            $res[] = $print . $arr[$index];
            return;
        }

        $used = [];  // 这个是存放已固定过的字符，避免出现重复字符而导致重复排序

        for ($i = $index; $i < $length; $i++) {
            if (in_array($arr[$i], $used)) continue; // 如果当前字符已固定过，则剪枝
            $used[] = $arr[$i];                      // 将字符添加进已固定字符的数组

            swap($arr[$index], $arr[$i]);  // 交换，i位置的字符与index位置的字符互换
            $this->dfs($index + 1, $arr, $res, $print . $arr[$index]);  // 递归，固定下一个位置的字符
            swap($arr[$index], $arr[$i]);  // 恢复交换
        }
    }
}

$str = 'abcc';
$obj = new strSingleSort();
//var_dump($obj->permutation($str));

$obj2 = new strRepeatSort();
var_dump($obj2->permutation($str));

$array  = [
    [1, 2, 8, 9],
    [2, 4, 9, 12],
    [4, 7, 10,13],
    [6, 8, 11,15]
];
