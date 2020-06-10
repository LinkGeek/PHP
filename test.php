<?php
//echo phpinfo();
//var_dump(PHP_INT_MIN);
//var_dump(-9223372036854775808);
//var_dump(gethostbyname('www.jiatengfei.com'));

//var_dump(__FILE__);
//var_dump(dirname(__FILE__));

//$app_name= isset($_REQUEST['app_name']) ? $_REQUEST['app_name'] : 0;
//var_dump($app_name);
//var_dump(intval('01MyName'));
//var_dump(intval('-1MyName'));
//if($app_name == '01MyName'){
//    echo 'true';
//} else {
//    echo 'false';
//}

//$users = array(2, 3);
//$user_id = 1;
//in_array($user_id, $users) || array_unshift($users, $user_id);
//
//print_r($users);
//array_unshift($users, array(5,6));
//print_r($users);

function quick_sort($arr)
{
    if (empty($arr) || count($arr) < 2) return $arr;

    $tmp = $arr[0];
    $leftArr = $rightArr = [];
    for ($i=1; $i<count($arr); $i++) {
        if ($arr[$i] > $tmp) {
            $rightArr[] = $arr[$i];
        } else {
            $leftArr[] = $arr[$i];
        }
    }

    return array_merge(quick_sort($leftArr), [$tmp], quick_sort($rightArr));
}

function bubble_sort($arr) {
    $len = count($arr);
    if (empty($arr) || $len < 2) return $arr;
    for ($i=0; $i<$len-1; $i++) {
        for ($j=0; $j<$len-1-$i; $j++) {
            $tmp = $arr[$j+1];
            if ($arr[$j] > $tmp) {
                $arr[$j+1] = $arr[$j];
                $arr[$j] = $tmp;
            }
        }
    }
    return $arr;
}

function select_sort($arr) {
    $len = count($arr);
    if ($len <= 1) {
        return $arr;
    }
    for ($i = 0; $i < $len - 1; $i++) {
        $min = $i;
        for ($j = $i+1; $j < $len; $j++) {
            if ($arr[$j] < $arr[$min]) {
                $min = $j;
            }
        }
        list($arr[$min], $arr[$i]) = [$arr[$i], $arr[$min]];
    }
    return $arr;
}

$arr = [5,72,45,27,88,60];
$arr = array(9,4,1,3,2,7,6,8);
//select_sort($arr);

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
var_dump(strCount('abbcddde'));
