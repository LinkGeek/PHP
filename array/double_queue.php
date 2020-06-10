<?php

// 使用数组模拟双向队列
$arr = [2,1,5,8];

//array_unshift(array, element)	在 array 开头插入元素 element
//array_push(array, element)	向 array 尾部插入元素（入栈），然后返回新数组的长度
//array_shift(array)	        删除 array 中的第一个元素，并返回被删除元素的值
//array_pop(array)	            删除 array 中的最后一个元素


array_shift($arr);
var_dump($arr); // [1,5,8];

array_unshift($arr, 44);
var_dump($arr); // [44,1,5,8];

array_pop($arr);
var_dump($arr); // [44,1,5];

array_push($arr, 55);
var_dump($arr); // [44,1,5,55];