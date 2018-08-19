<?php

$json = '[{"id":1,"prov":1,"city":0,"channel":1,"isOpen":1,"isUseParent":1,"tickTime":5,"sleepTime":100,"horse":[{"isOpen":1,"playType":1,"weekDate":[1,2,3,4,5,6],"beginDate":"","endDate":"","beginTime":"02:00","endTime":"22:00","content":"\u5faa\u73af\u64ad\u653e:\u8dd1\u9a6c\u706f1"},{"isOpen":1,"playType":2,"weekDate":[],"beginDate":"2018-07-30","endDate":"2018-09-15","beginTime":"02:00","endTime":"22:00","content":"\u6307\u5b9a\u65f6\u95f4\u64ad\u653e"}],"lastUpdateTime":"2018-08-07 12:08:22"},{"id":2,"prov":2,"city":1501,"channel":0,"isOpen":1,"isUseParent":1,"tickTime":5,"sleepTime":105,"horse":[{"isOpen":1,"playType":1,"weekDate":[1,2,3,4,5,6],"beginDate":"","endDate":"","beginTime":"02:00","endTime":"22:00","content":"\u5faa\u73af\u64ad\u653e:\u8dd1\u9a6c\u706f1"},{"isOpen":1,"playType":2,"weekDate":[],"beginDate":"2018-07-30","endDate":"2018-09-15","beginTime":"02:00","endTime":"22:00","content":"\u6307\u5b9a\u65f6\u95f4\u64ad\u653e"}],"lastUpdateTime":"2018-08-07 12:08:22"},{"id":3,"prov":0,"city":51,"channel":3,"isOpen":1,"isUseParent":1,"tickTime":5,"sleepTime":300,"horse":[{"isOpen":"1","playType":"2","weekDate":"","beginDate":"2018-08-17","endDate":"2018-08-18","beginTime":"14:00","endTime":"15:00","content":"\u4e03\u5915\u8282\u5feb\u4e501"},{"isOpen":"0","playType":"1","weekDate":["5"],"beginDate":"","endDate":"","beginTime":"14:00","endTime":"15:00","content":"\u4e03\u5915\u8282\u5feb\u4e50\u91cd\u590d2"}],"lastUpdateTime":"2018-08-17 15:03:54"}]';

$arr = json_decode($json, true);
echo "<pre>";
//print_r($arr); die;

$prov = 0;
$city = 51;
$channel = 3;

$len = count($arr); print_r($len);

$newHorse = array(
	'id' => 819,
    'prov' => 51,
    'city' => 1503,
    'channel' => 2,
    'isOpen' => 1,
    'isUseParent' => 1,
    'tickTime' => 5,
    'sleepTime' => 100,
    'horsr' => array(),
);

foreach ($arr as $k => $v1) {
	//print_r($v1); echo "<hr/>";
	if($v1['prov'] == $prov && $v1['city'] == $city && $v1['channel'] == $channel){
		//print_r($arr[$k]);
		$arr[$k]['id'] = 100;
	}

	if($v1['prov'] != $prov || $v1['city'] != $city || $v1['channel'] != $channel){
		//print_r($arr[$k]);
		$arr[$len] = $newHorse;
		break;
	}

}

print_r($arr);

$newJson = json_encode($arr,true);
print_r($newJson);