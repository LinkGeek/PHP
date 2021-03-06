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
 * 总结：
 * 1. 外层循环要元素数 - 1次。负责找出最大值。
 * 2. 内层循环逐层递减一次。负责俩俩相比较，交换元素位置。
*/
function bubbleSort($arr) {
    $len = count($arr);
    for ($i=0; $i<$len-1; $i++) {
        for($j=0; $j<$len-$i-1; $j++) {
            if ($arr[$j] > $arr[$j+1]) {
                list($arr[$j], $arr[$j+1]) = [$arr[$j+1], $arr[$j]];
            }
        }
    }
    return $arr;
}
$arr = [8, 9, 3, 6, 1, 4];
//p(bubbleSort($arr));

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
    $left_arr = $right_arr = [];
    for ($i=1; $i<$len; $i++) {
        if ($arr[$i] < $base_num) {
            $left_arr[] = $arr[$i];
        } else {
            $right_arr[] = $arr[$i];
        }
    }

    return array_merge(quickSort($left_arr), [$base_num], quickSort($right_arr));
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
    if ($len <= 1) {
        return $arr;
    }

    //双重循环完成，外层控制轮数，内层控制比较次数
    for ($i = 0; $i < $len - 1; $i++) {
        $p = $i;
        for ($j = $i+1; $j < $len; $j++) {
            //比较，发现更小的,记录下最小值的位置；并且在下次比较时采用已知的最小值进行比较。
            if ($arr[$j] < $arr[$p]) {
                $p = $j;
            }
        }
        //已经确定了当前的最小值的位置，保存到$p中。如果发现最小值的位置与当前假设的位置$i不同，则位置互换即可。
        if($p != $i) {
            list($arr[$p], $arr[$i]) = [$arr[$i], $arr[$p]];
        }
    }
    return $arr;
}
//p(selectSort($arr));

/**
 * 4.插入排序
 * 思路分析：在要排序的一组数中，假设前面的数已经是排好顺序的，现在要把第n个数插到前面的有序数中，
 * 使得这n个数也是排好顺序的。如此反复循环，直到全部排好顺序。
 */
function insertSort($arr) {
    $len = count($arr);
    if ($len <= 1) {
        return $arr;
    }
    for ($i=0; $i<$len-1; $i++) {
        //内层循环控制，比较并插入
        for ($j=$i+1; $j>0; $j--) {
            if ($arr[$j-1] > $arr[$j]) {
                list($arr[$j], $arr[$j-1]) = [$arr[$j-1], $arr[$j]];
            }
        }
    }
    return $arr;
}

function insertSort2($arr) {
    $len = count($arr);
    for ($i=1; $i<$len; $i++) {
        $tmp = $arr[$i];
        //内层循环控制，比较并插入
        for($j=$i-1; $j>=0; $j--) {
            if($tmp < $arr[$j]) {
                //发现插入的元素要小，交换位置，将后边的元素与前面的元素互换
                $arr[$j+1] = $arr[$j];
                $arr[$j] = $tmp;
            } else {
                //如果碰到不需要移动的元素，由于是已经排序好是数组，则前面的就不需要再次比较了。
                break;
            }
        }
    }
    return $arr;
}

$arr = [5,1,7,2,8,4];
//p(insertSort($arr));

/**
 * 5、给出一个字符串，返回里面连续字母的个数，比如：abbcddde,返回 1a2b1c3d1e;
 */
function strCount($str) {
    $arr = str_split($str);
    $key = 0; //key 用来记录下标，为了方便计算前面的数字
    $ret = '';
    for ($i=0; $i<count($arr); $i++) {
        if (($i+1) < count($arr) && $arr[$i] == $arr[$i+1]) {
            continue; //如果当前的值和下一个值相等，跳出当前循环，进入下一个
        } else {
            $ret .= ($i-$key+1).$arr[$i]; //不相等时计算出前面的数字
            $key = $i + 1; //同时key下标重新复制
        }
    }
    return $ret;
}
//p(strCount('abbcddde')); // 1a2b1c3d1e

/**
 * 桶排序
 * @param $arr
 * @return array
 */
function bucket_sort($arr){
    $result=[];
    $length=count($arr);
    //入桶
    for($i=0,$max=$arr[$i];$i<$length;$i++){
        if ($max<$arr[$i]) {
            $max=$arr[$i];
        }
        $bucket[$arr[$i]]=[];
        array_push($bucket[$arr[$i]],$arr[$i]);
    }
    //出桶
    for($i=0;$i<=$max;$i++){
        if(!empty($bucket[$i])){
            $l=count($bucket[$i]);
            for ($j=0; $j <$l ; $j++) {
                $result[]=$bucket[$i][$j];
            }
        }
    }
    return $result;
}

/**
 * 第一种桶排序的办法，每个桶存储相同值的数据
 *
 */
function bucketSort($nonSortArray){
    //选出桶中最大值和最小值
    $min = min($nonSortArray);
    $max = max($nonSortArray);

    //生成桶,默认每个桶中数据只有0个
    $bucket = array_fill($min, $max-$min+1, 0);

    //数据入桶
    foreach ($nonSortArray as $value){
        $bucket[$value]++; //对应桶的个数计增
    }

    //数据出桶
    $sortArray = array();
    foreach ($bucket as $k => $v){
        for($i=1; $i<=$v; $i++){
            $sortArray[] = $k; //每个桶中的数据个数
        }
    }
    return $sortArray;
}
$array = array(58,5,96,75,4,69,82,35,64,15,23,69,8,5,2,52);
$arr = bucketSort($array);
echo implode(",", $arr);
