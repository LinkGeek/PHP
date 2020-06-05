<?php


$arr = array('Hello','World!','I','love','Shenzhen!');
$str = "Hello World! I love Shenzhen!";

echo implode(" ", $arr);
print_r (explode(" ", $str));
print_r (str_split($str, 4));

// 输出：
/*Hello World! I love Shenzhen!

// 输出：
    (
    [0] => Hello
    [1] => World!
    [2] => I
    [3] => love
    [4] => Shenzhen!
    )

    // 输出：
    (
    [0] => Hell
    [1] => o Wo
    [2] => rld!
    [3] =>  I l
    [4] => ove
    [5] => Shen
    [6] => zhen
    [7] => !
    )
*/

echo "<hr/>";

$a1 = array("a"=>"red","b"=>"green","c"=>"blue","d"=>"yellow");
// 反转数组中所有的键以及它们关联的值：
$result = array_flip($a1);
print_r($result);
print_r(array_flip([1,3,110]));

// 比较两个副本的键名，并返回交集：
$gameMap = [1=>'血流', 2=>'血战',3=>'斗地主',4=>'二人'];
$online = [1,2,3];
$onlineMap = array_intersect_key($gameMap, array_flip($online));
print_r($onlineMap);


$arr = ['car'=>'BMW','bicycle','airplane'];
$str1 = current($arr); //初始指向插入到数组中的第一个单元。
$str2 = next($arr);    //将数组中的内部指针向前移动一位
$str3 = current($arr); //指针指向它“当前的”单元
$str4 = prev($arr);    //将数组的内部指针倒回一位
$str5 = end($arr);     //将数组的内部指针指向最后一个单元
reset($arr);           //将数组的内部指针指向第一个单元
$str6 = current($arr);
$key1 = key($arr);     //从关联数组中取得键名

echo $str1 . PHP_EOL; //BMW
echo $str2 . PHP_EOL; //bicycle
echo $str3 . PHP_EOL; //bicycle
echo $str4 . PHP_EOL; //BMW
echo $str5 . PHP_EOL; //airplane
echo $str6 . PHP_EOL; //BMW
echo $key1 . PHP_EOL; //car
var_dump($arr);   //原数组不变


/**
 * PHP数组的交集
 * array_intersect()函数是求两个数组的交集，返回一个交集共有元素的数组（只是数组值的比较）
 * array_intersect_assoc()函数是将键和值绑定，一起比较交集部分
 * array_intersect_key()函数是将两个数组的键值进行比较，返回键值交集的数组
 */


/**
 * PHP数组的差集
 * array_diff()返回出现在第一个数组中但其他输入数组中没有的值
 * array_diff_assoc() 与array_diff()基本相同，只是它在比较时还考虑了数组的键
 */


/**
 * PHP数组的并集
 */



/**
 * PHP数组的合并
 */
