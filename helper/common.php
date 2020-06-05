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
 * PHP列出目录下的文件名
 * @param $DirPath
 */
function listDirFiles($DirPath){
    if($dir = opendir($DirPath)){
        while(($file = readdir($dir)) !== false){
            if(!is_dir($DirPath.$file)){
                echo "filename: $file<br />";
            }
        }
    }
}

listDirFiles('../server/');

