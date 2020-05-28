<?php

set_time_limit(0);

ini_set('default_socket_timeout', -1);

$channelName = "testPubSub";
$channelName2 = "testPubSub2";

try {
    $redis = new Redis();
    // 建立一个长链接
    $res = $redis->pconnect('127.0.0.1', 6379,0);
    // 阻塞获取消息
    $redis->subscribe(array($channelName, $channelName2), 'callback');
} catch (Exception $e) {
    echo $e->getMessage();
}

// 回调函数,这里写处理逻辑
function callback($instance, $channelName, $message) {
    echo "channel:".$channelName.", message:".$message."\n";
}