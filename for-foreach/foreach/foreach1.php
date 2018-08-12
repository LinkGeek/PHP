<?php

// foreach 循环只适用于数组，并用于遍历数组中的每个键/值对

$colors = array("red","green","blue","yellow"); 
foreach ($colors as $value) {
   echo "$value <br>";
}

// 结果
/*
red 
green 
blue 
yellow 
*/

echo "<hr/>";

/**************************************************/

/*
* foreach如何跳出两层循环
*/
$arr1 = array('a1','a2','a3','a4');
$arr2 = array('b1','b2','b3','b4');

foreach ($arr1 as $v1){
  foreach ($arr2 as $k => $v2){
    if( $k == 2){
      break 2;
    }
    echo $v1.'==='.$v2.'<br/>';
  }
}
