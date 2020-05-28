<?php

$channelName = "testPubSub";
$channelName2 = "testPubSub2";

//向指定频道发送消息
try {
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);
    for ($i=0; $i<5; $i++){
        $data = array('key' => 'key'.$i, 'data' => 'testdata');
        $param = array('publish', $channelName, json_encode($data));
        // 频道的订阅数量
        $ret = call_user_func_array(array($redis, 'rawCommand'), $param);
        print_r($ret);
    }
} catch (Exception $e){
    echo $e->getMessage();
}