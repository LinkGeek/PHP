<?php

/**
 * 使用数组模拟双向队列
 * Class Deque
 */
class Deque {

    private $queue = [];

    public function __construct($arr) {
        $this->queue = $arr;
    }

    /**
     * 从开头插入
     * @param $item
     * @return array
     */
    public function firstIn($item) {
        array_unshift($this->queue, $item);
        return $this->queue;
    }

    /**
     * 从尾部插入
     * @param $item
     * @return array
     */
    public function lastIn($item) {
        array_push($this->queue, $item);
        return $this->queue;
    }

    /**
     * 从头部弹出
     * @return mixed
     */
    public function firstOut() {
        return array_shift($this->queue);
    }

    /**
     * 从尾部弹出
     * @return mixed
     */
    public function lastOut() {
        return array_pop($this->queue);
    }
}

$arr = [2,1,5,8];
$obj = new Deque($arr);
$arr = $obj->firstIn(3);
var_dump($arr);

$arr = $obj->lastIn(9);
var_dump($arr);

$arr = $obj->firstOut();
var_dump($arr); // 3

$arr = $obj->lastOut();
var_dump($arr); // 9

//array_unshift(array, element)	在 array 开头插入元素 element, 然后返回新数组的长度
//array_push(array, element)	向 array 尾部插入元素（入栈），然后返回新数组的长度
//array_shift(array)	        删除 array 中的第一个元素，并返回被删除元素的值
//array_pop(array)	            删除 array 中的最后一个元素，并返回被删除元素的值