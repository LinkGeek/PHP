<?php

class Card {

    // 根据身份证算年龄
    public function getIdCardAge($idCard) {
        // 获取身份证日期
        $birth_time = strtotime(substr($idCard, 6, 8));
        $y = date('Y', $birth_time);
        $m = date('m', $birth_time);
        $d = date('d', $birth_time);

        // 获取当前时间
        $cur_y = date('Y');
        $cur_m = date('m');
        $cur_d = date('d');

        // 计算年龄
        $age = $cur_y - $y;
        if ($m > $cur_m || $m == $cur_m && $d > $cur_d) {
            $age--;
        }
        return $age;
    }
}

$card = new Card();
$age = $card->getIdCardAge('450422199212283872');
var_dump($age);