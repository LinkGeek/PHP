<?php


## 写一个正则表达式去除$str中的所有html标签
$str = "";
preg_replace("/<(\/?html.*?)>/si","", $str);

## 获取img标签中的src值
$img = '<img alt="gaoqing" id="" src="a.jpg" />';
$preg = '/<img.*?src="(.*?)".*?\/?>/i';
$preg = '/<img[\s]*src=[\'|\"](.*)[\'|\"][\s]*\/>/';
preg_match($preg, $img, $match);
//var_dump($match);


## 邮箱格式正则
$reg = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
$reg = '/^[\w\-\.]+@[\w\-]+(\.\w+)+$/';

## URL的正则表达式
$reg = '/^(https?|ftps?):\/\/(www)\.([^\.\/]+)\.(com|cn|org)(\/[\w-\.\/\?\%\&\=]*)?/i';

## 139开头手机号码
$phone = 13988888888;
$preg = '/^139\d{8}$/';
preg_match($preg, $phone, $match);
if (!preg_match($preg, $phone)) {
    echo "手机号码不符合";
}
//var_dump($match);

## 写一个函数，获取一篇文章内容中的全部图片，并下载
function download_images($article_url, $image_path = 'tmp'){

    // 获取文章内容
    $content = file_get_contents($article_url);

    // 利用正则表达式得到图片链接
    $reg_tag = '/<img.*?\"([^\"]*(jpg|bmp|jpeg|gif|png)).*?>/';
    $reg_tag = '/<img[^>]*src="([^"]*)"[^>]*>/i';
    $reg_tag = "/<img[^>]+src=(?:'|\")?([^>'\" ]+)/i";
    preg_match_all($reg_tag, $content, $matches);
    $pic_list = array_unique($matches[1]);
    //var_dump($pic_list);

    foreach($pic_list as $pic_url){
        $content = @file_get_contents($pic_url);
        if ($content == false) {
            continue;
        }

        // 获取图片文件后缀
        $ext = strrchr($pic_url, '.');
        $filename = './tmp/'.uniqid() . $ext;
        file_put_contents($filename, $content);
    }
}
$url = 'https://mbd.baidu.com/newspage/data/landingsuper?context=%7B%22nid%22%3A%22news_9082668070582274515%22%7D&n_type=0&p_from=1';
download_images($url);
