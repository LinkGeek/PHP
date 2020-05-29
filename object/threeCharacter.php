<?php

/**
 * 1、封装性
 */
class privateClass {

    private $a;
    private $b;

    private function privateFun()
    {
        echo "这是封装的方法";
    }
}

/**
 * 2、继承性
 */
// 父类
class parentClass {
    function p1() {
        echo '这是父类p1方法';
    }
    function p2() {
        echo '这是父类p2方法';
    }
}

// 子类：php仅支持单继承，即一个子类只有一个父类
class subClass extends parentClass {
    function p1() {
        echo '这是子类p1方法';
    }
    function p2() {
        parent::p2();
        echo '这是子类p2方法';
    }
}
$sc = new subClass();
//$sc->p1();
//$sc->p2();

// 解决单继承问题
trait pA {
    function a() {
        echo 'pa-a()';
    }
}
trait pB {
    function b() {
        echo 'pb-b()';
    }
}

class pC {
    use pA, pB;

    function c() {
        echo 'pc-c()';
    }
}

$sc = new pC();
//$sc->a();


/**
 * 抽象技术
 */
abstract class AnimalWorld{

    abstract public function eat(); // 抽象方法

    // 呼吸
    public function breath(){
        echo "动物都需要呼吸 <br/>";
    }
}
// 抽象类是不能被实例化的
//$animal = new AnimalWorld();

// 定义狗类
class Dog extends AnimalWorld {
    // 实现抽象类中的抽象方法
    function eat(){
        echo "小狗啃骨头";
    }
}
$dog = new Dog();
$dog->breath();

/**
 * 3、多态性
 * 在php中多态地实现需要一个类通过多个子类地继承实现，如果一个类的方法在多个子类中重写并实现不同的功能，我们称之为多态
 */

interface Eat {
    public function eat($food);
}

class Food {
    public $name = "";
    public function  __construct($name) {
        $this->name = $name;
    }
}

// 人类
class Human implements Eat {

    public $name = "";
    public function  __construct($name) {
        $this->name = $name;
    }

    public function eat($food) {
        echo $this->name."吃了".$food->name."<br/>";
    }

    public function feed($obj, $food){
        if($obj instanceof Eat){
            $obj->eat($food);
        } else {
            echo "该对象没有实现Eat的方法<br/>";
        }
    }
}

// 鸡
class Chicken implements Eat {
    public $count = 5;
    public function eat($food) {
        echo $this->count."小鸡们，都吃了".$food->name."<br/>";
    }
}

//定义狗的类
class Dogs implements Eat{
    public $count = 5;
    public function eat($food){
        echo $this->count."只小狗们，都吃了".$food->name."<br/>";
    }
}

//创建对象
$liu = new Human("小刘");
$chickens = new Chicken();
$dogs = new Dogs();

//创建食物
$xfFood = new Food("稀饭");
$seedsFood = new Food("米");
$mealFood = new Food("残羹剩饭");

//老人吃稀饭
$liu->eat($xfFood);

//老人喂食开始
$liu->feed($chickens,$seedsFood);//给小鸡喂食
$liu->feed($dogs,$mealFood);//给小狗喂食