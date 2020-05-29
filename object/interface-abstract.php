<?php

# 接口
interface Human{

    const TEST_CONST = "test const"; // 定义常量

    // public $v; // error，不能定义变量
    // static $count; // error，不能定义变量

    public function speak();
    public function walk();
    public function run();
}

# 抽象类
abstract class Father implements Human{

    public function construct(){
        echo "father init n";
    }

    abstract public function walk(); // 抽象方法

    public function speak(){
        echo "father speak skill n";
    }

    public function run(){
        echo "father run skill n";
    }
}

# 非抽象类
class Mother implements Human{

    public function construct(){
        echo "mother init n";
    }

    # 这里必须实现walk方法
    public function walk(){
        echo "mother walk skill n";
    }

    public function speak(){
        echo "mother speak skill n";
    }

    public function run(){
        echo "mother run skill n";
    }
}

class Son extends Father{

    public function walk(){
        echo "son walk skill. n";
    }

    public function speak($name = ''){
        echo "son: ". $name ." speak skill. n";
    }

    # 访问控制必须和父类中一样（或者更为宽松）
    protected function sport(){
        echo "son sport skill. n";
    }

    final public function notTeach(){
        echo 'son has not to teach skill';
    }
}



class Daughter extends Mother{

    public function run($name = ''){
        echo "daughter run skill. n";
    }
}

final class GrandChild extends Son{

    # 访问控制必须和父类中一样（或者更为宽松）
    public function sport(){
        echo "GrandChild sport skill. n";
    }

    # Cannot override final method Son::notTeach()

    // public function notTeach(){} // error
}



#  Class Orphan may not inherit from final class (GrandChild)

// class Orphan extends GrandChild{}  // error

$son = new Son();

$son->speak("Suly");

$daughter = new Daughter();

$daughter->run('Lily');

$grandChild = new GrandChild();

$grandChild->sport();