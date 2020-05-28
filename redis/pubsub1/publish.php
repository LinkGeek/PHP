<?php

$channelName = "testPubSub";
$channelName2 = "testPubSub2";

try {
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379,0);

    for ($i=0; $i<5; $i++) {
        $data = array('key' => 'key'.$i, 'data' => 'test-data');
        $ret = $redis->publish($channelName, json_encode($data));
        // 频道的订阅数
        print_r($ret);
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
