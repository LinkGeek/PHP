<?php

class Person {

    public static $id = 1;
    public $username = '';
    private $pwd;
    private $sex;

    public function run() {
        echo '<br/>running';
    }
}

// 建立反射类
$class = new ReflectionClass('Person');

// 实例化
$instance = $class->newInstance();
print_r($instance);

// 所有的属性
$properties = $class->getProperties();
var_dump($properties);

foreach($properties as $property) {
    echo "<br/>" . $property->getName(); // 属性名
    //echo "<br/>" . $property->getValue();
}

var_dump($class->getProperty('id')->getValue());
var_dump($class->getProperty('username')->getValue(new Person));


// 获取方法(methods)
$methods = $class->getMethods();
var_dump($methods);

$instance->run();


//$private_properties = $class->getProperties(ReflectionProperty::IS_PRIVATE);