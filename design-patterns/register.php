<?php

/**
 * 单例模式
 */
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

/**
 * 工厂模式
 */
class Factory {
    public static function createDb(){
        return Db::getInstance();
    }
}

/**
 * 注册树模式
 */
class Register
{
    // 用一个数组来当做对象池，键当做对象别名，值存储具体对象
    public static $objTree = [];

    // 将对象放在对象池
    public static function set($key, $val)
    {
        return self::$objTree[$key] = $val;
    }

    // 通过对象别名在对象池中获取到对象别名
    public static function get($key)
    {
        return self::$objTree[$key];
    }

    // 通过对象别名将对象从对象池中注销
    public static function _unset($key)
    {
        unset(self::$objTree[$key]);
    }
}

Register::set('db', Factory::createDb());
$db = Register::get('db');
var_dump($db);
