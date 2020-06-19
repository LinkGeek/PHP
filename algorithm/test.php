<?php

// 最大公约数
$a = 12;
$b = 42;
while ($a != $b) {
    if ($a > $b) {
        $a = $a - $b;
    } else {
        $b = $b - $a;
    }
}
echo $a.'|'. $b ."<hr/>";

// 鸡兔同笼问题：鸡和兔子共计 10 只，把它们
//的脚加起来共计 32 只，问鸡和兔子分别有多少只？
for ($i=0; $i<=10; $i++) {
    for ($j=0; $j<=10; $j++) {
        $a = $i + $j;
        $b = $i*2 + $j*4;
        if ($a==10 && $b==32) {
            echo "有鸡{$i}只；兔{$j}只";
        }
    }
}

# 1,1,2,3,5,8,13,21,34.....
function recursionNum($arr, $pos) {
    for ($i=2; $i<=$pos; $i++) {
        $arr[] = $arr[$i-2] + $arr[$i-1];
    }
    return $arr;
}
$arr = [1, 1];
var_dump(recursionNum($arr, 30));