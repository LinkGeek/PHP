<?php

$f = fopen('./order.log', 'r');
while ($line = fgets($f)) {
    if (empty($line)) {
        continue;
    }
    $arr = explode(' ', $line);
    if (count($arr) != 3) {
        continue;
    }

    //var_dump($line);
}
fclose($f);