<?php


namespace lib;


class Helper
{
    /**
     * 处理乱码的错误信息(比如socket，tcp。。。)
     * @param $str
     * @return null|string|string[]
     */
    public static function doEncoding($str){
        $encode = strtoupper(mb_detect_encoding($str, ["ASCII",'UTF-8',"GB2312","GBK",'BIG5']));
        if($encode!='UTF-8'){
            $str = mb_convert_encoding($str, 'UTF-8', $encode);
        }
        return $str;
    }

}