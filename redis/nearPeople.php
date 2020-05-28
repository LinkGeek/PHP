<?php

/**
 * 查找附近人
 * Class NearPeople
 */
class NearPeople {

    private $oRedis = null;    //连接对象
    private $connect = false;

    public function __construct() {
        $this->oRedis = new Redis();
        $this->connect = $this->oRedis->connect('127.0.0.1', 6379);
        if (!$this->connect) {
            die('connect failed');
        }
    }

    /**
     * 录入位置
     * @param $key
     * @param $member
     * @param $lng
     * @param $lat
     */
    function addLocation($key, $member, $lng, $lat)
    {
        $this->oRedis->geoadd($key, $lng, $lat, $member);
    }

    /**
     * 地址的经纬度信息
     * @param $key
     * @param $member
     * @return array
     */
    function getLocation($key, $member)
    {
        return $this->oRedis->geopos($key, $member);
    }

    /**
     * 获取小A和小B之间的距离
     * @param $key
     * @param $member1
     * @param $member2
     * @param string $unit
     * @return float
     */
    function twoPointsDistance($key, $member1, $member2, $unit='km')
    {
        return $this->oRedis->geodist($key, $member1, $member2, $unit);
    }

    /**
     * 查询指定元素附近的其它元素
     * @param $key
     * @param $member
     * @param $radius 半径距离
     * @param string $unit 单位 'm' => 米，'km' => 千米，'mi' => 英里，'ft' => 尺
     * @param int $count 返回指定数量的结果
     * @param bool $withDist 匹配位置与给定地理位置的距离
     * @param bool $withCoord 匹配位置的经纬度
     * @param string $order 排序
     * @return array
     */
    function near($key, $member, $radius, $unit='km', $count=0, $withDist=true, $withCoord=false, $order='ASC')
    {
        $options = [$order];
        if ($count > 0) {
            $options['count'] = $count;
        }
        if ($withDist) {
            $options[] = 'WITHDIST';
        }
        if ($withCoord) {
            $options[] = 'WITHCOORD';
        }

        return $this->oRedis->geoRadiusByMember($key, $member, $radius, $unit, $options);
    }

    /**
     * 获取指定位置范围内的地理信息位置集合
     * @param $key
     * @param $lng
     * @param $lat
     * @param $radius
     * @param string $unit
     * @param int $count
     * @param bool $withDist
     * @param bool $withCoord
     * @param string $order
     * @return mixed
     */
    function getPointsNear($key, $lng, $lat, $radius, $unit='km', $count=0, $withDist=true, $withCoord=false, $order='ASC')
    {
        $options = [$order];
        if ($count > 0) {
            $options['count'] = $count;
        }
        if ($withDist) {
            $options[] = 'WITHDIST';
        }
        if ($withCoord) {
            $options[] = 'WITHCOORD';
        }

        return $this->oRedis->geoRadius($key, $lng, $lat, $radius, $unit, $options);
    }
}

$positionArr = [
    [117.230279, 31.81676, 'a'],
    [117.229704, 31.824676, 'b'],
    [117.300419, 31.696095, 'c'],
    [117.192909, 31.732465, 'd'],
    [117.189604, 31.838297, 'e'],
];

$cl = new NearPeople();
// 写入
/*foreach ($positionArr as $v) {
    $cl->addLocation ('location', $v[2], $v[0], $v[1]);
}*/

// 获取两个地点的距离
$result = $cl->twoPointsDistance('location', 'a', 'b');
//var_dump($result);

// 指定范围内
$result = $cl->getPointsNear('location', 117.175571, 31.846746, 10);
var_dump($result);

// 查找附近人
$result = $cl->near('location', 'a', 5);
//var_dump($result);