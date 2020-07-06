<?php

class Worker{
    //工人的一些属性
    private $name_;
    private $age_;
    private $salary_;

    //构造方法
    public function __construct($name,$age,$salary){
        $this->name_ = $name;
        $this->age_ = $age;
        $this->salary_ = $salary;
    }
    //输出工人信息的方法
    public function show(){
        echo "年龄".$this->salary_;
        echo "姓名".$this->name_;
        echo "工资".$this->salary_;
    }

    //__toString方法
    public function __toString(){
        return "年龄：".$this->age."，姓名：".$this->name."工资：".$this->salary;
    }

}