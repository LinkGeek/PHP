<?php

/**
 * php屏蔽关键字
 * @param $str
 * @param $file
 * @return mixed
 */
function shieldText6($str, $file){
    $sensitive_word = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . $file);
    $arr = explode('|', $sensitive_word);
    foreach ($arr as $val) {
        $len = strlen($val);
        $newArr[$len][] = $val;
    }

    $count = count($arr);
    $tmp = array_keys($newArr);
    rsort($tmp);
    for ($i = 0; $i <= 3; $i++) {
        foreach ($tmp as $v) {
            foreach ($newArr[$v] as $v1) {
                $str = str_replace($v1, '**', $str);
            }
        }
    }

    return $str;
}

/**
 * Curl抓取
 * @param $url
 * @param array $data
 * @param string $method
 * @return bool|string
 */
function curl($url, $data=array(), $method="GET"){
    //初始化
    $ch = curl_init();

    //设置参数
    curl_setopt($ch, CURLOPT_URL, $url);//设施url参数
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);//设置请求method参数
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //传值
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // 执行
    $tmpInfo = curl_exec($ch);
    if (curl_errno($ch)) {
        return curl_error($ch);
    }

    //关闭
    curl_close($ch);
    return $tmpInfo;
}

/**
 * 获取用户真实IP
 * @return array|false|mixed|string
 */
function getIp() {
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
        $ip = getenv("HTTP_CLIENT_IP");
    elseif (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    elseif (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
        $ip = getenv("REMOTE_ADDR");
    elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
        $ip = $_SERVER['REMOTE_ADDR'];
    else
        $ip = "unknown";
    return $ip;
}

/**
 * 遍历一个文件夹下的所有文件和子文件夹
 * @param $dir
 * @return array
 */
function my_scandir($dir)
{
    $files = [];

    if(!is_dir($dir)) {
        return $files;
    }

    $handle = opendir($dir);
    if ($handle) {
        while(false !== ($file = readdir($handle)))
        {
            if($file != '.' && $file != '..' && $file != '.svn'){
                $filename = $dir . "/"  . $file;
                if(is_file($filename)){
                    $files[] = $filename;
                }else{
                    $files[$file] = my_scandir($filename);
                }
            }
        }

        closedir($handle);
    }

    return $files;
}
//my_scandir('./server');

/**
 * 无限分类
 * @param $arr
 * @param int $pid
 * @param int $level
 * @return array
 */
function tree($arr, $pid=0, $level=0){
    static $list = array();
    foreach ($arr as $v) {
        //如果是顶级分类，则将其存到$list中，并以此节点为根节点，遍历其子节点
        if ($v['pid'] == $pid) {
            $v['level'] = $level;
            $list[] = $v;
            tree($arr, $v['id'],$level+1);
        }
    }

    return $list;
}
$arr = array(
    array('id'=>1,'name'=>'电脑','pid'=>0),
    array('id'=>3,'name'=>'笔记本','pid'=>1),
    array('id'=>4,'name'=>'台式机','pid'=>1),
    array('id'=>7,'name'=>'超级本','pid'=>3),
    array('id'=>8,'name'=>'游戏本','pid'=>3),

    array('id'=>2,'name'=>'手机','pid'=>0),
    array('id'=>5,'name'=>'智能机','pid'=>2),
    array('id'=>6,'name'=>'功能机','pid'=>2),
);
//var_dump(tree($arr));

/**
 * 判断一个字符串是否是合法的日期模式：2007-03-13 13:13:13
 * @param $date
 * @return bool
 */
function checkDateTime($date) {
    if (date('Y-m-d H:i:s', strtotime($date)) == $date) {
        return true;
    } else {
        return false;
    }
}
$data = '2015-06-40 13:35:42';
var_dump(checkDateTime($data));//bool(true)