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
        $cont = curl($urls[$i]);
        //echo $cont. PHP_EOL;
        $proc->write($cont. PHP_EOL);
    }, true);

    $pid = $process->start();
    $workers[$pid] = $process;
}

foreach ($workers as $proc) {
    echo $proc->read(). PHP_EOL;
}

/**
 * 模拟curl
 * @param $url
 * @return string
 */
function curl($url) {
    sleep(1);
    return $url.', success'.PHP_EOL;
}
echo date("Y-m-d H:i:s").PHP_EOL;

