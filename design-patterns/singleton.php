<?php

class Db {
    //该静态属性用于存储该类唯一实例
    private static $_instance = null;

    /**
     * 防止使用 new 创建多个实例
     */
    private function __construct(){

    }

    /**
     * 防止 clone 多个实例
     */
    public function __clone(){

    }

    /**
     * 防止反序列化
     */
    private function __wakeup(){
    }

    public static function getInstance(){
        if(!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}
$db1 = Db::getInstance();
$db2 = Db::getInstance();
var_dump($db1);
var_dump($db2);

// object(Db)#1 (0) { } object(Db)#1 (0) { }  句柄一样