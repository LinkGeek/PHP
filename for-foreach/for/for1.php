<?php

//如果您已经提前确定脚本运行的次数，可以使用 for 循环
$people = Array(
        Array('name' => 'Kalle', 'salt' => 856412), 
        Array('name' => 'Pierre', 'salt' => 215863)
        );

for($i = 0, $size = count($people); $i < $size; ++$i)
{
    $people[$i]['salt'] = rand(000000, 999999);
}
echo count($people);
echo "<pre>";
var_dump($people);

/*
2
array(2) {
  [0]=>
  array(2) {
    ["name"]=>
    string(5) "Kalle"
    ["salt"]=>
    int(434265)
  }
  [1]=>
  array(2) {
    ["name"]=>
    string(6) "Pierre"
    ["salt"]=>
    int(275617)
  }
}
*/

/*
* for循环嵌套
* for循环嵌套的话将优先执行内循环，再执行外循环
*/

/*for($i=0; $i<10; $i++) {//外循环开始
    //这里是外循环的循环体
    for($j=0; $j<20; $j++)//内循环开始
    {
        //这里是内循环的循环体
    }
}*/

 // 此时$i=0；在此过程中当执行到内循环处时开始执行内循环，$j由0递增到19；执行完20遍内循环后外循环结束，$i++；此时$i=1，再次开始执行外循环

 for($i=1;$i<=9;$i++){
    echo $i.": ".$j."<br/>";
    for($j=1;$j<=$i;$j++){
    	
    }
}
/*
1: 
2: 2
3: 3
4: 4
5: 5
6: 6
7: 7
8: 8
9: 9
*/