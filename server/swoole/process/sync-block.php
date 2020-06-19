<?php

## 同步阻塞管道进行进程间通信

$worker_process_nums = 5;
$worker_process = [];

for ($i = 0; $i < $worker_process_nums; $i++) {
    //创建子进程
    //默认为每个子进程创建一个管道，如果不想创建设置$pipe_type参数为false
    //注意管道默认是同步阻塞，半双工，如果读取不到数据就会阻塞
    $worker = new swoole_process(function (swoole_process $worker) {
        //注意，如果主进程中不写数据write()，那么子进程这里read()就会阻塞
        $task = json_decode($worker->read(), true);

        //进行计算任务
        $tmp = 0;
        for ($i = $task['start']; $i < $task['end']; $i++) {
            $tmp += $i;
        }

        echo '子进程 PID : ', $worker->pid, ' 计算 ', $task['start'], ' - ', $task['end'], ' 结果 : ', $tmp, PHP_EOL;
        //往管道中写入计算的结果
        $worker->write($tmp);
        //子进程退出
        $worker->exit();
    });

    //保存子进程
    $worker_process[$i] = $worker;

    //启动子进程
    $worker->start();
}

//往每个子进程管道中投递任务
for ($i = 0; $i < $worker_process_nums; $i++) {
    $worker_process[$i]->write(json_encode([
        'start' => mt_rand(1, 10),
        'end' => mt_rand(50, 100),
    ]));
}

//父进程监听子进程退出信号，回收子进程，防止出现僵尸进程
swoole_process::signal(SIGCHLD, function ($sig) {
    //必须为false，非阻塞模式
    while ($ret = swoole_process::wait(false)) {
        echo "子进程 PID : {$ret['pid']} 退出\n";
    }
});