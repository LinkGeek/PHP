<?php

/***
 * Class Timer
 */

class Timer extends SplMinHeap
{
    /**
     * 比较根节点和新插入节点大小
     * @param mixed $value1
     * @param mixed $value2
     * @return int
     */
    protected function compare($value1, $value2)
    {
        if ($value1['timeout'] > $value2['timeout']) {
            return -1;
        }
        if ($value1['timeout'] < $value2['timeout']) {
            return 1;
        }
        return 0;
    }

    /**
     * 插入节点
     * @param mixed $value
     */
    public function insert($value)
    {
        $value['timeout'] = time() + $value['expire'];
        parent::insert($value);
    }

    /**
     * 监听
     * @param bool $debug
     */
    public function monitor($debug = false)
    {
        while (!$this->isEmpty()) {
            $this->exec($debug);
            usleep(1000);
        }
    }

    /**
     * 执行
     * @param $debug
     */
    private function exec($debug)
    {
        $hit = 0;
        $t1  = microtime(true);
        while (!$this->isEmpty()) {
            $node = $this->top();
            if ($node['timeout'] <= time()) {
                //出堆或入堆
                $node['repeat'] ? $this->insert($this->extract()) : $this->extract();
                $hit = 1;
                //开启子进程
                if (pcntl_fork() == 0) {
                    empty($node['action']) ? '' : call_user_func($node['action']);
                    exit(0);
                }

                //忽略子进程,子进程退出由系统回收
                pcntl_signal(SIGCLD, SIG_IGN);
            } else {
                break;
            }
        }

        $t2 = microtime(true);
        echo ($debug && $hit) ? '时间堆 - 调整耗时: ' . round($t2 - $t1, 3) . "秒\r\n" : '';
    }
}

    $timer = new Timer();

    //注册 - 3s - 重复触发
    $timer->insert(array('expire' => 3, 'repeat' => true, 'action' => function(){
        echo '3秒 - 重复 - hello world' . "\r\n";
    }));

    //注册 - 3s - 重复触发
    $timer->insert(array('expire' => 3, 'repeat' => true, 'action' => function(){
        echo '3秒 - 重复 - gogo' . "\r\n";
    }));

    //注册 - 6s - 触发一次
    $timer->insert(array('expire' => 6, 'repeat' => true, 'action' => function(){
        echo '6秒 - 一次 - hello xxxx' . "\r\n";
    }));

    //监听
    $timer->monitor(false);