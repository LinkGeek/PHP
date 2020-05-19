<?php

/**有三个容积分别为3升、5升、8升的水桶，
其中容积为8升的水桶中装满了水，容积为3升和容积为5升的水桶都是空的。
三个水桶都没有刻度，现在需要将大水桶中的8升水等分成两份，每份都是4升水，
附加条件是只能这三个水桶，不能借助其他辅助容器。

人的思维
解决这个问题的关键是怎么通过倒水凑出确定的1升水或能容纳1升水的空间。

例如，当8L水桶或5L水桶或3L水桶有1L水时，都能快速倒出4L水。

计算机思维
“穷举法”

水桶初始状态：8L水桶装满水，3L和5L的水桶为空。
水桶最终状态：3L水桶为空，5L和8L的水桶各4L水。

假设将每个状态下三个水桶中的水的体积作为status。

从 得到status = array(4,4,0)。

当然还会有一些限制：

1.各个水桶的都有最大值：

0 <= status[0] <= 8;

0 <= status[1] <= 5;

0 <= status[2] <= 3;

2.当前倒水之后各个水桶的状态，与历史倒水之后各个水桶的状态，不能相同。

3.当前水桶为空时，不能倒给其他水桶。

4.当前水桶为最大容积时，其他水桶不能再向这个水桶倒水。
*/


/**
 * 三个水桶等分8升水的问题
 */
class Bucket
{
    static protected $_change_bucket_path = []; //倒水的过程记录

    protected $_bucket_values;  //每个水桶的当前容积
    protected $_bucket_limit;   //每个水桶的容积阈值
    protected $_history_status; //所有历史水桶容积状态的集合

    public function __construct($bucket_value = [], $bucket_limit = [], $history_status = [])
    {
        $this->_bucket_values  = $bucket_value;
        $this->_bucket_limit   = $bucket_limit;
        $this->_history_status = array_merge($history_status, [$this->_bucket_values]);

        $this->run();
    }

    public function run() {
        // 8, 0, 0
        for ($i=0; $i<count($this->_bucket_values); $i++) {
            for ($j=$i+1; $j<count($this->_bucket_values); $j++) {
                $this->changeBucketValue($i, $j);
                $this->changeBucketValue($j, $i);
            }
        }
    }

    /**
     * 倒水
     * @param int $target_idx  目标水桶（被倒水的水桶）
     * @param int $current_idx 当前水桶（倒水的水桶）
     * @return bool
     */
    protected function changeBucketValue($target_idx = 0, $current_idx = 0) {
        $value = $this->_bucket_values;
        if ($target_idx == $current_idx ||
            $this->_bucket_values[$current_idx] == 0 ||
            $this->_bucket_values[$target_idx] == $this->_bucket_limit[$target_idx]
        ) {
            return false;
        }

        if (($this->_bucket_limit[$target_idx] - $this->_bucket_values[$target_idx]) <= $this->_bucket_values[$current_idx]) {
            $water = $this->_bucket_limit[$target_idx] - $this->_bucket_values[$target_idx];
        } else {
            $water = $this->_bucket_values[$current_idx];
        }

        $value[$target_idx] += $water;
        $value[$current_idx] -= $water;

        if ($value === [4,4,0]) {
            self::$_change_bucket_path[] = array_merge($this->_history_status, [$value]);
        } else {
            if (!$this->checkBucketStatus($value)) {
                new Bucket($value, $this->_bucket_limit, $this->_history_status);
            }
        }
    }

    /**
     * 验证当前水桶状态是否存在过
     * @param array $current_status 当前水桶状态
     * @return bool
     */
    protected function checkBucketStatus($current_status = []) {
        foreach ($this->_history_status as $k) {
            if ($current_status === $k) {
                return true;
            }
        }
        return false;
    }

    public function getResult() {
        return self::$_change_bucket_path;
    }
}

$bucket_limit = [8, 5, 3];
$bucket_value = [8, 0, 0];
$bucket = new Bucket($bucket_value, $bucket_limit, []);
$result = $bucket->getResult();

echo "一共有 ".count($result)." 种倒水方法，方法如下：<br> <pre>";
print_r($result);