<?php

// 定时器

// 每2秒执行一次
swoole_timer_tick(2000, function ($time_id){
    echo "tick-2000ms\n";
});

// 3秒后执行
swoole_timer_after(3000, function (){
    echo "after 3000ms.\n";
});