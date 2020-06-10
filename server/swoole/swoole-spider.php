<?php

function creatProcess($i, $url)
{
    // 每次过来统计一下进程数量
    $cmd = "ps -ef |grep swoole-spider |grep -v grep |wc -l";
    $pCount = system($cmd);//进程数量
    if ($pCount < 200) {
        // 创建子进程
        $process = new swoole_process(function (swoole_process $worker) use ($i, $url) {
            $content = curlData($url);//方法里面处理你的逻辑
        });
        $pid = $process->start();
        echo $url . '------第' . $i . '个子进程创建完毕'.PHP_EOL;
    } else {
        sleep(10);//可以根据实际情况定义
        creatProcess($i, $url);
    }
}

function curlData($url)
{
    sleep(10);//为了让子进程多存在一段时间，方便看到效果
    $content = file_get_contents($url);
    file_put_contents("./sData/baidu.txt","tttttttttttttttt".$content,FILE_APPEND);
}

echo "process-start-time:" . date("Ymd H:i:s") . PHP_EOL;
$baseUrl = "http://www.baidu.com/";
$count = 1000;
for ($i = 0; $i < $count; $i++) {
    creatProcess($i, $baseUrl);
}

echo "process-end-time:" . date("Ymd H:i:s");