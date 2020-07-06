<?php

/**
 * 延迟队列
 * Class DelayQueue
 */
class DelayQueue
{
    protected $prefix = 'delay_queue:';
    protected $redis = null;
    protected $key = '';

    public function __construct($queue, $config = [])
    {
        $this->key = $this->prefix . $queue;
        $this->redis = new Redis();
        $this->redis->connect($config['host'], $config['port'], $config['timeout']);
        $this->redis->auth($config['auth']);
        //$ret = $this->redis->get('user:token:4');
        //var_dump($this->redis, $ret);die;
    }

    public function delTask($value)
    {
        return $this->redis->zRem($this->key, $value);
    }

    public function addTask($name, $time, $data)
    {
        //添加任务，以时间作为score，对任务队列按时间从小到大排序
        return $this->redis->zAdd(
            $this->key,
            $time,
            json_encode([
                'task_name' => $name,
                'task_time' => $time,
                'task_params' => $data,
            ], JSON_UNESCAPED_UNICODE)
        );
    }

    public function getTask()
    {
        //获取任务，以0和当前时间为区间，返回一条记录
        return $this->redis->zRangeByScore($this->key, 0, time());
    }

    public function run()
    {
        //每次只取一条任务
        $task = $this->getTask();var_dump(22,$task);die;
        if (empty($task)) {
            return false;
        }
        $task = $task[0];
        //有并发的可能，这里通过zrem返回值判断谁抢到该任务
        if ($this->delTask($task)) {
            $task = json_decode($task, true);
            //处理任务
            echo '任务：' . $task['task_name'] . ' 运行时间：' . date('Y-m-d H:i:s') . PHP_EOL;
            return true;
        }
        return false;
    }
}

/*$dq = new DelayQueue('close_order', [
    'host' => '127.0.0.1',
    'port' => 6379,
    'auth' => '',
    'timeout' => 60,
]);
$dq->addTask('close_order_111', time() + 30, ['order_id' => '111']);
$dq->addTask('close_order_222', time() + 60, ['order_id' => '222']);
$dq->addTask('close_order_333', time() + 90, ['order_id' => '333']);*/

/*while (true) {
    $dq->run();
    usleep(100000);
}*/