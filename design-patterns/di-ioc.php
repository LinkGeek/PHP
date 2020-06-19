<?php

interface animals {
    function eat();
}

class cat implements animals {
    function eat(){
        echo 'this is cat eat action'.PHP_EOL;
    }
}

class pig implements animals {
    function eat(){
        echo 'this is pig eat action'.PHP_EOL;
    }
}

# 初极版
class snake implements animals {
    protected $name = '';
    function __construct($name){
        $this->name = $name;
    }

    function eat(){
        echo $this->name."snake eat method".PHP_EOL;
    }
}

# 终极版
class Ioc {

    protected $binds;
    protected $instances;

    /**
     * 添加一个resolve到registry数组中
     * @param string $name 依赖标识
     * @param object $resolve 一个匿名函数用来创建实例
     * @return void
     */
    public function register($name, $resolve) {
        if ($resolve instanceof Closure) { // 闭包化
            $this->binds[$name] = $resolve;
        } else {
            $this->instances[$name] = $resolve; // 正常实例化
        }
    }

    /**
     * 返回一个实例
     * @param string $name 依赖标识
     * @param array $arg 传参
     * @return mixed
     */
    public function make($name, $arg=[]) {
        if (isset($this->instances[$name])) {
            return $this->instances[$name];
        }

        array_unshift($arg, $this);
        return call_user_func_array($this->binds[$name], $arg);
    }
}

$ioc = new Ioc();
$pig = new pig();
$ioc->register('Pig', $pig);
$pig_eat = $ioc->make('Pig');
$pig_eat->eat();

$snake = new snake('neinei');
$ioc->register('Snake', $snake);
$snake_eat = $ioc->make('Snake');
$snake_eat->eat();

$ioc->register('Cat',function(){
    return new cat;
});
$cat_eat = $ioc->make('Cat');
$cat_eat->eat();