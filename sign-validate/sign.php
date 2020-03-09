<?php

/**
 * 签名参数sign生成的方法：
 * 第1步: 将所有参数（注意是所有参数），除去sign本身，以及值是空的参数，按参数名字母升序排序。
 * 第2步: 然后把排序后的参数按参数1值1参数2值2…参数n值n（这里的参数和值必须是传输参数的原始值，不能是经过处理的，如不能将&quot;转成”后再拼接）的方式拼接成一个字符串。
 * 第3步: 把分配给接入方的验证密钥key拼接在第2步得到的字符串前面。
 * 第2步: 在上一步得到的字符串前面加上验证密钥key(这里的密钥key是接口提供方分配给接口接入方的)，然后计算md5值，得到32位字符串，然后转成大写.
 * 第4步: 计算第3步字符串的md5值(32位)，然后转成大写,得到的字符串作为sign的值
 */

// 设置一个公钥(key)和私钥(secret)，公钥用于区分用户，私钥加密数据，不能公开
$key = "c4ca4238a0b923820dcc509a6f75849b";
$secret = "28c8edde3d61a0411511d3b1866f0636";

// 待发送的数据包
$data = array(
    'username' => 'abc@qq.com',
    'sex' => '1',
    'age' => '16',
    'kong' => '',
    'arr' => array('name'=>'test'),
    'addr' => 'guangzhou',
    'key' => $key,
    'timestamp' => time(),
);

// 获取sign
function getSign($secret, $data) {
    // 对数组的值按key排序
    ksort($data);
    // 生成url的形式
    $params = http_build_query($data);
    // 生成sign
    $sign = md5($params . $secret);
    return $sign;
}

// 发送的数据加上sign
$data['sign'] = getSign($secret, $data);

// 验证sign是否合法
function verifySign($secret, $data) {
    // 验证参数中是否有签名
    if (!isset($data['sign']) || !$data['sign']) {
        echo '发送的数据签名不存在';
        die();
    }
    if (!isset($data['timestamp']) || !$data['timestamp']) {
        echo '发送的数据参数不合法';
        die();
    }
    // 验证请求， 10分钟失效
    if (time() - $data['timestamp'] > 600) {
        echo '验证失效， 请重新发送请求';
        die();
    }
    $sign = $data['sign'];
    unset($data['sign']);
    ksort($data);
    $params = http_build_query($data);
    // $secret是通过key在api的数据库中查询得到
    $sign2 = md5($params . $secret);
    if ($sign == $sign2) {
        die('验证通过');
    } else {
        die('请求不合法');
    }
}

verifySign($secret, $data);