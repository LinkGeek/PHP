<?php

    /************************ 常见的排序算法 ******************************/

    $arr = array(1,43,54,62,21,66,32,78,36,76,39);

    function p() {
        header("Content-Type: text/html; charset=UTF-8");
        $argc = func_get_args();
        foreach ($argc as $val) {
            echo '<pre>';
            print_r($val);
        }
        die;
    };

    /**
     * 1. 冒泡排序
     * 思路分析：在要排序的一组数中，对当前还未排好的序列，从前往后对相邻的两个数依次进行比较和调整，
     * 让较大的数往下沉，较小的往上冒。即，每当两相邻的数比较后发现它们的排序与排序要求相反时，就将它们互换。
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
    //$arr1 = bubbleSort($arr);
    //p($arr1);

    /**
     * 2. 快速排序
     * 思路分析：在要排序的一组数中，对当前还未排好的序列，从前往后对相邻的两个数依次进行比较和调整，
     * 让较大的数往下沉，较小的往上冒。即，每当两相邻的数比较后发现它们的排序与排序要求相反时，就将它们互换。
     */
    function quickSort($arr) {
        $len = count($arr);
        if ($len <= 1) {
            return $arr;
        }

        $base_num = $arr[0];
        $left_arr = array();
        $right_arr = array();
        for ($i=1; $i<$len; $i++) {
            if ($arr[$i] < $base_num) {
                $left_arr[] = $arr[$i];
            } else {
                $right_arr[] = $arr[$i];
            }
        }

        $left_arr = quickSort($left_arr);
        $right_arr = quickSort($right_arr);
        return array_merge($left_arr, array($base_num), $right_arr);
    }
    //$arr2 = quickSort($arr);
    //p($arr2);

    /**
     * 3. 选择排序
     * 思路分析：在要排序的一组数中，选出最小的一个数与第一个位置的数交换。
     * 然后在剩下的数当中再找最小的与第二个位置的数交换，如此循环到倒数第二个数和最后一个数比较为止。
     */
    function selectSort($arr) {
        $len = count($arr);
        for ($i=0; $i<$len; $i++) {
            $min = $i;
            for ($k=0; $k<$len-$i; $k++) {

            }
        }
    }

    /**
     * 4.插入排序
     * 思路分析：在要排序的一组数中，假设前面的数已经是排好顺序的，现在要把第n个数插到前面的有序数中，
     * 使得这n个数也是排好顺序的。如此反复循环，直到全部排好顺序。
     */
    function insertSort($arr) {
        $len = count($arr);
        for ($i=1; $i<$len; $i++) {

        }
    }

    /**
     * 5、给出一个字符串，返回里面连续字母的个数，比如：abbcddde,返回 1a2b1c3de;
     */
    function strCount($str) {
        $arr = str_split($str);
        $key = 0; //key 用来记录下标，为了方便计算前面的数字
        $ret = '';
        for ($i=0; $i<count($arr); $i++) {
            if (($i+1) < count($arr) && $arr[$i] == $arr[$i+1]) {
                continue;
            } else {
                $ret .= ($i-$key+1).$arr[$i];
                $key = $i + 1;
            }
        }
        return $ret;
    }
    // p(strCount('abbcddde'));

    /**
     * 6、约瑟夫环问题，猴子选大王
     * 一群猴子排成一圈，按1,2,…,n依次编号。然后从第1只开始数，数到第m只,把它踢出圈，
     * 从它后面再开始数，再数到第m只，在把它踢出去…，如此不停的进行下去，直到最后只剩下一只猴子为止，那只猴子就叫做大王。
     * 要求编程模拟此过程，输入m、n, 输出最后那个大王的编号。
     */
    function selectKing($n, $m) {
        $arr = range(1, $n);
        $i = 1;
        while (count($arr) > 1) {
            ($i % $m != 0) && array_push($arr, $arr[$i-1]);
            unset($arr[$i-1]);
            $i++;
        }
        return $arr[$i-1];
    }
    p(selectKing(6, 8));