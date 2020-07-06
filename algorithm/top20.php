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
//echo selectKing(10, 7).PHP_EOL;

/**
 * 有一母牛，到4岁可生育，每年一头，所生均是一样的母牛，
 * 到15岁绝育，不再能生，20岁死亡，问n年后有多少头牛。
 */
function niu($year) {
    static $num = 1; //初始化牛数量
    for ($i = 1; $i <= $year; $i++) {
        if ($i >= 4 && $i < 15) {
            $num++;
            //echo "i: $i, num: $num".PHP_EOL;
            niu($year-$i); // 递归计算小牛$num，成长年数$year-$i
        } elseif ($i == 20) { // 20岁减一
            $num--;
        }
    }
    return $num;
}
//echo niu(5);

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
 * 9X9口诀
 */
function doubleNight()
{
    for ($i=1; $i<=9; $i++) {
        for ($j=1; $j<= $i; $j++) {
            $str = ($j*$i) >= 10 ? ' ' : " &nbsp;";
            echo $j.'*'.$i.'='.$j*$i. $str;
            echo ' ';
        }
        echo '<br/>';
    }
}
//doubleNight();

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
 * 从一个标准的Url提取出文件的扩展名
 */
function getUrlExt($url)
{
    $arr = parse_url($url); // parse_url解析一个 URL 并返回一个关联数组，包含在 URL 中出现的各种组成部分
    // 'scheme' => string 'http' (length=4)
    // 'host' => string 'www.php100.com' (length=14)
    // 'path' => string '/9/20/22/87462.html' (length=19)
    $file = basename($arr['path']); // basename函数返回路径中的文件名部分
    $ext = explode('.', $file);
    return $ext[count($ext)-1];
}
//echo getUrlExt('http://www.php100.com/9/20/22/87462.html');

/**
 * 截取文件名后缀
 * @param $file
 */
function getFileExt($file) {
    // 1.
    echo substr(strrchr($file, '.'), 1);

    // 2.
    echo substr($file, strpos($file, '.')+1);

    // 3.
    $arr = explode('.', $file);
    echo $arr[count($arr)-1];
    echo end($arr);

    // 4.
    echo strrev(explode('.', $file)[0]);
}

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

function tree($list, $pid=0) {
    $tree = [];
    foreach ($list as $item) {
        if ($item['pid'] == $pid) {
            $item['children'] = tree($list, $item['id']);
            $tree[] = $item;
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
//var_dump(tree($arr));

/**
 * 随机输入一个数字能查询到对应的数据区间
 */
function regionSearch($arr, $num) {
    $len = count($arr);
    $low = 0;
    $high = $len - 1;
    while ($low <= $high) {
        //$mid = intval(($low + $high) / 2);
        $mid = ($low + $high) / 2;
        var_dump($low, $high, $mid, intval($mid));
        echo "===========".PHP_EOL;
        $mid = intval($mid);
        if ($arr[$mid] >= $num) {
            $high = $mid - 1;
        } elseif($arr[$mid] <= $num) {
            $low = $mid + 1;
        }
    }
    //var_dump($low, $high);

    return "在区间 $arr[$high] 到 $arr[$low] 之间";
}
$arr = [1, 50, 100, 150, 200];
//echo regionSearch($arr, 80);

/**
 * 洗牌算法
 */
function wash_card($card_num=54) {
    $cards = [];
    $tmp = range(1, $card_num);
    for ($i=0; $i<$card_num; $i++) {
        $index = rand(0, $card_num-$i-1);
        $cards[$i] = $tmp[$index];
        unset($tmp[$index]);
        $tmp = array_values($tmp);
    }
    return $cards;
}
//var_dump(wash_card());

/**
 * 区级质数个数
 * 判断素数的方法：用一个数分别去除2到sqrt(这个数)，如果能被整除，
 * 则表明此数不是素数，反之是素数
 */
function getPrimeNum($start=101, $end=200) {
    $arr = [];
    for ($i=$start; $i<=$end; $i++) {
        $flag = true;
        for ($j=2; $j<=sqrt($i); $j++) {
            if ($i % $j == 0) {
                $flag = false;
            }
        }
        if ($flag) {
            $arr[] = $i;
        }
    }
    return $arr;
}
//var_dump(getPrimeNum());

/**
 * 10 瓶水，其中一瓶有毒，小白鼠喝完有毒的水之后，会在 24 小时后死亡，
 * 问：最少用几只小白鼠可以在 24 小时后找到具体是哪一瓶水有毒。
 * 思路：一只老鼠有两种状态，死活，对应01，假设老鼠的个数为 A，则有 2^A种状态；
 */

/**
 0 0 0 1  1
 0 0 1 0  2
 0 0 1 1  3
 0 1 0 0  4
 0 1 0 1  5
 0 1 1 0  6
 0 1 1 1  7
 1 0 0 0  8
 1 0 0 1  9
 1 0 1 0  10

 A B C D

将1到10瓶水编号，转化为二进制就是0001，0010，0011....，1表示喝，0表示不喝，四只老鼠A/B/C/D分别去喝对应那一列数字为1的水。
如果A死了，其他三只老鼠没死，那就是第八瓶有毒；如果A和C死了，那就是第十瓶有毒。
 */
