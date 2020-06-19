<?php

$arr = ['a', 'b', 'c'];
foreach ($arr as $k => $val) {
    $val = &$arr[$k];
    var_dump($arr);
}