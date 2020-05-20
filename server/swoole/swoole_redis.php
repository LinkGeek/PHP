<?php
$http = new swoole_http_server("0.0.0.0", 9509);   // 监听 9509

$http->set(array(
    'reactor_num' => 2,  //reactor thread num
    'worker_num' => 4    //worker process num
));

$http->on('request', function (swoole_http_request $request, swoole_http_response $response) {
    $uniqid = uniqid('uid-', TRUE);    // 模拟唯一用户ID
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);    // 连接 redis

    $redis->watch('rest_count');  // 监测 rest_count 是否被其它的进程更改

    $rest_count = intval($redis->get("rest_count"));  // 模拟唯一订单ID
    if ($rest_count > 0){
        $value = "{$rest_count}-{$uniqid}";  // 表示当前订单，被当前用户抢到了

        // do something ... 主要是模拟用户抢到单后可能要进行的一些密集运算
        $rand  = rand(100, 1000000);
        $sum = 0;
        for ($i = 0; $i < $rand; $i++) {$sum += $i;}

        // redis 事务
        $redis->multi();
        $redis->lPush('uniqids', $value);
        $redis->decr('rest_count');
        $replies = $redis->exec();  // 执行以上 redis 事务

        // 如果 rest_count 的值被其它的并发进程更改了，以上事务将回滚
        if (!$replies) {
            echo "订单 {$value} 回滚" . PHP_EOL;
        }
    }
    $redis->unwatch();
});

$http->start();