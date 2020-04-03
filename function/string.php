<?php

// 说明：获取 abc.jpeg 后缀名
$fileName = 'abc.jpeg';
echo substr($fileName, strrpos($fileName, "."));
// 输出：.jpeg

echo substr($fileName, strrpos($fileName, "."), 2);
// 输出：.j

$str = explode('.', $fileName);
var_dump($str);