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
