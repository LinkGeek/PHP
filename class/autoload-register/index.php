<?php

## 第一种方式：官方不赞成使用
/*function __autoload($class) {
    $file = $class . '.php';
    if ( is_file($file) ) {
        require_once($file);
    }
}*/

## 第二种方式：
/*spl_autoload_register(function ($class_name) {
    $file = $class_name . '.php';
    if (is_file($file)) {
        require_once $file;
    }
});*/

## 第三种方式：函数
/*function autoLoad($class) {
    $file = $class . '.php';
    if (is_file($file)) {
        require_once($file);
    }
}
spl_autoload_register('autoLoad');*/

## 第四种方式：调用静态方法
class Fc {
    public static function autoLoad($className)
    {
        $file = $className . '.php';
        if (is_file($file)) {
            require_once $file;
        }
        return true;
    }
}
/*spl_autoload_register(array(
    'fc',
    'autoLoad'
));*/
//另一种写法：
spl_autoload_register("fc::autoLoad");

$obj  = new MyClass1();
$obj->test();

$obj2 = new MyClass2();
$obj2->test();