<?php

class Factory {
    public static function createDb(){
        echo '统一生产一个Db实例'. PHP_EOL;
        return new Db();
    }
}

class Db {
    public function __construct() {
        echo '我是'. __CLASS__ .'类'. PHP_EOL;
    }
}

$db = Factory::createDb();