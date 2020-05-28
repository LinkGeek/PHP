<?php

//设置php脚本执行时间
set_time_limit(0);
//设置socket连接超时时间
ini_set('default_socket_timeout', -1);

//声明测试频道名称
$channelName = "testPubSub";
$channelName2 = "testPubSub2";

try {
    $redis = new Redis();
    //建立一个长链接
    $redis->pconnect('127.0.0.1', 6379);
    //阻塞获取消息
    while (true){
        //构建命令参数
        $param = array('subscribe', $channelName, $channelName2);
        //使用call_user_func_array回调执行命令
        $ret = call_user_func_array(array($redis, 'rawCommand'), $param);
        //如果结果是消息结构
        if (isset($ret[0]) && $ret[0] == 'message'){
            //输出消息频道和消息内容
            echo "channel:".$ret[1].",message:".$ret[2]."\n";
        } else {
            //没有消息休眠1秒
            sleep(1);
        }
    }
} catch (Exception $e){
    echo $e->getMessage();
}