<?php

//var_dump(PHP_INT_MIN);
//var_dump(-9223372036854775808);
//var_dump(gethostbyname('www.jiatengfei.com'));

//var_dump(__FILE__);
//var_dump(dirname(__FILE__));

$app_name= isset($_REQUEST['app_name']) ? $_REQUEST['app_name'] : 0;
var_dump($app_name);
var_dump(intval('01MyName'));
var_dump(intval('-1MyName'));
if($app_name == '01MyName'){
    echo 'true';
} else {
    echo 'false';
}