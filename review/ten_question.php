<?php

    // Q1 第一个问题关于弱类型
    $str1 = 'yabadabadoo';
    $str2 = 'yaba';
    $pos = strpos($str1, $str2);
    var_dump($pos);
    if ($pos) {
        echo "\"" . $str1 . "\" contains \"" . $str2 . "\"";
    }
    if ($pos !== false) {
        echo "\"" . $str1 . "\" contains \"" . $str2 . "\"";
    }
    echo "<hr />";

    // Q2 下面的输出结果会是怎样？
    $x = 5;
    echo $x;
    echo "<br />";
    echo $x+++$x++;
    echo "<br />";
    echo $x;
    echo "<br />";
    echo $x---$x--;
    echo "<br />";
    echo $x;
    echo "<hr />";

    // Q3 关于变量的引用
    $a = '1';
    $b = &$a;
    $b = "2$b";
    var_dump($a, $b);
    echo "<hr />";

    // Q4 下面是true还是false
    var_dump(0123 == 123);
    var_dump('0123' == 123);
    var_dump('0123' === 123);
    echo "<hr />";

    // Q9 下面的输出结果会是什么
    $v = 1;
    $m = 2;
    $l = 3;
    if(($l > $m) > $v){
        echo "yes";
    }else{
        echo "no";
    }
    echo "<hr />";