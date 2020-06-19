<?php

$url_arr = array();
for ($i=0; $i<10; $i++){
    $url_arr[] = "www.baidu.com?wd=".$i;
}

echo "start:".date("Y-m-d H:i:s").PHP_EOL;

$workers = array();
// 开启5个进程执行
for ($i=0; $i<5; $i++){
    $process = new swoole_process('getContents', true);
    $process->start();
    $process->write($i); // 传递$i
    $workers[] = $process;
}

//主进程数据结果
foreach ($workers as $process){
    echo $process->read();
    echo PHP_EOL;
}
echo "end:".date("Y-m-d H:i:s").PHP_EOL;

function getContents(swoole_process $worker){
    $i = $worker->read(); // 获取$i
    global $url_arr;
    $res1 = execCurl($url_arr[($i*2)]);
    $res2 = execCurl($url_arr[($i*2+1)]);
    echo $res1.$res2;
    //$worker->exit();
}

/**
 * 模拟curl
 * @param $url
 * @return string
 */
function execCurl($url){
    sleep(2);
    return "handle ".$url." finished".PHP_EOL;
}