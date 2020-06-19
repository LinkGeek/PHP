<?php

use Swoole\Process;

echo date("Y-m-d H:i:s").PHP_EOL;
$urls = [
    'https://www.baidu.com',
    'https://www.swoole.com',
    'https://www.hao123.com',
    'http://php.net/manual/zh/index.php',
    'https://github.com',
    'https://www.qq.com',
];
$workers = [];

for($i=0; $i<6; $i++) {
    $process = new Process(function (Process $proc) use($i, $urls) {
        //获取子进程执行的结果
        $cont = curl($urls[$i]);
        //将子进程执行的结果存入管道
        $proc->write($cont. PHP_EOL);
    }, true); //true表明不输出屏幕，写入管道，从管道中读取

    //启动成功，返回子进程id
    $pid = $process->start();
    //从管道中读取进程执行的结果
    $workers[$pid] = $process;
}

foreach ($workers as $proc) {
    //从管道中读取子进程执行的结果
    echo $proc->read(). PHP_EOL;
}

/**
 * 模拟curl
 * @param $url
 * @return string
 */
function curl($url) {
    sleep(1);
    return strtoupper($url);
}
echo date("Y-m-d H:i:s").PHP_EOL;

