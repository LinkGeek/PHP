<?php

/**
 * 约瑟夫环问题，猴子选大王
 * 一群猴子排成一圈，按1,2,…,n依次编号。然后从第1只开始数，数到第m只,把它踢出圈，
 * 从它后面再开始数，再数到第m只，在把它踢出去…，如此不停的进行下去，直到最后只剩下一只猴子为止，那只猴子就叫做大王。
 * 要求编程模拟此过程，输入m、n, 输出最后那个大王的编号。
 */
function selectKing($n, $m) {
    $monkeys = range(1, $n); // 猴群编号
    $i = 0;
    while (count($monkeys) > 1) {
        // $i数组下标，$i+1编号
        (($i+1) % $m != 0) && array_push($monkeys, $monkeys[$i]);
        unset($monkeys[$i]);
        $i++;
    }
    return current($monkeys);
}
//echo selectKing(8, 6);

/**
 * 有一母牛，到4岁可生育，每年一头，所生均是一样的母牛，
 * 到15岁绝育，不再能生，20岁死亡，问n年后有多少头牛。
 */
function niu($year) {
    static $num = 1; //初始化牛数量
    for ($i = 1; $i <= $year; $i++) {
        if ($i >= 4 && $i < 15) {
            $num++;
            niu($year-$i); // 递归计算小牛$num，成长年数$year-$i
        } elseif ($i == 20) { // 20岁减一
            $num--;
        }
    }
    return $num;
}

/**
 * 杨辉三角
 * @param int $n 要求的层数
 * 理解思路：$i代表行数; $j代表列数
 * 每一行除第一个数和最后一个数为1，
 * 其他数为上一行同位置的数+上一行同位置的前一个数之和。
 * 那么可以理解为一个二维数组
 */
function funYH($n=3){
    $arr = [];
    for ($i=1; $i<=$n; $i++) {
        for ($j=1; $j<=$i; $j++) {
            if ($j==1 || $j==$i) {
                $arr[$i][$j] = 1;
            } else {
                $arr[$i][$j] = $arr[$i-1][$j-1] + $arr[$i-1][$j];
            }
            echo $arr[$i][$j]."\t";
        }
        echo "<br/>";
    }
}
//funYH(5);

/**
 * 奇异算法
 */
function test()
{
    $a = 1;
    //$b = &$a;
    echo (++$a) + (++$a);
}
//test(); // 5

/**
 * 字符集合：输入一个字符串，求出该字符串包含的字符集合，并按顺序排序（英文）
 */
function strSet($str) {
    $arr = str_split($str);
    $arr = array_unique($arr);
    sort($arr);
    return implode('', $arr);
}
//echo strSet('eacdbcb');

/**
 * 遍历一个文件下的所有文件和子文件夹下的文件
 */
function getAllFile($dir) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) != false) {
            if ($file != '.' && $file != '..') {
                if (is_dir($dir.'/'.$file)) {
                    getAllFile($dir.'/'.$file);
                } else {
                    echo $dir.'/'.$file. "<br/>";
                }
            }
        }
    }
}
//getAllFile('/data/www/github/php');

/**
 * 从一个标准的Url提取出文件的扩展名
 */
function getUrlExt($url) {
    $arr = parse_url($url);
    //var_dump($arr);
    $file = basename($arr['path']);
    //var_dump($file);
    $ext = explode('.', $file);
    return $ext[count($ext)-1];
}
$url = 'http://www.php100.com/9/20/22/87462.html';
//echo getUrlExt($url);

/**
 * 斐波那契数列
 * 有个人想上一个n级的台阶，每次只能迈1级或者迈2级台阶，
 * 问：这个人有多少种方法可以把台阶走完？
 * 例如：总共3级台阶，可以先迈1级再迈2级，或者先迈2级再迈1级，
 * 或者迈3次1级总共3中方式
 */
function taijie($n=3) {
    return $n < 2 ? 1 : taijie($n-1) + taijie($n-2);
}
// var_dump(taijie(4)); // 5种

/**
 * 请写一段PHP代码，确保多个进程同时写入同一个文件成功
 */
function asyncWrite() {
    $fp = fopen('lock.txt', 'w+');
    if (flock($fp, LOCK_EX)) {
        fwrite($fp, 'hello world');
        flock($fp, LOCK_UN);
    } else {
        echo 'file in locking...';
    }
    fclose($fp);
}

/**
 * 无限级分类
 */
function getChild($arr, $pid=0, $level=0) {
    $tree = [];
    $newData = [];
    foreach ($arr as $item) {
        $newData[$item['id']] = $item;
    }
    foreach ($newData as $key => $v) {
        if ($v['pid']==$pid) {
            $newData[$v['pid']]['child'][] = &$newData[$key];
        } else {
            $tree[] = $newData[$v['id']];
        }
    }
    return $tree;
}
$arr = array(
    array('id'=>1,'name'=>'电脑','pid'=>0),
    array('id'=>2,'name'=>'手机','pid'=>0),
    array('id'=>3,'name'=>'笔记本','pid'=>1),
    array('id'=>4,'name'=>'台式机','pid'=>1),
    array('id'=>5,'name'=>'智能机','pid'=>2),
    array('id'=>6,'name'=>'功能机','pid'=>2),
    array('id'=>7,'name'=>'超级本','pid'=>3),
    array('id'=>8,'name'=>'游戏本','pid'=>3),
);
var_dump(getChild($arr));